<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/11 0011
 * Time: 15:48
 */

namespace frontend\controllers;


use app\models\Address;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use frontend\models\Cart;
use frontend\models\Delivery;
use frontend\models\Order;
use frontend\models\OrderGoods;
use frontend\models\Payment;
use yii\data\Pagination;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;

class GoodsController extends Controller
{
    public function actionIndex()
    {
        $models = GoodsCategory::find()->where(['parent_id' => 0])->all();
        //var_dump($goods);exit;
        return $this->render('index', ['models' => $models]);
    }

    /**
     *
     */
    public function actionList()
    {
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $pager = new Pagination();
        $child = GoodsCategory::findOne(['id' => $id]);


        switch ($child->depth) {
            case 0:
            case 1:
                $ids = $child->children()->select(['id'])->andWhere(['depth' => 2])->asArray()->column();
                //var_dump($ids);exit;
                $models = Goods::find()->where(['in', 'goods_category_id', $ids])//->limit($pager->limit)->offset($pager->offset)
                ->all();
                //$query = $models;
//        $pager->totalCount = $query->count();
//        $pager->defaultPageSize = 8;
                break;
            case 2:
                $ids = [$id];
                $models = Goods::find()->where(['in', 'goods_category_id', $ids])//->limit($pager->limit)->offset($pager->offset)
                ->all();
                //$query = $models;
                //$pager->totalCount = $query->count();
                $pager->defaultPageSize = 10;
        }
        return $this->render('list', ['models' => $models]);
    }

    public function actionGoods()
    {
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $model = Goods::findOne(['id' => $id]);
        $intro = GoodsIntro::findOne(['goods_id' => $id]);
        $pic = GoodsGallery::find()->where(['goods_id' => $id])->all();
        // var_dump($pic);exit;
        //var_dump($model);exit;
        return $this->render('goods', ['model' => $model, 'intro' => $intro, 'pic' => $pic]);
    }

    public function actionAddCart($goods_id, $count)
    {
        if (\Yii::$app->user->isGuest) {//未登录
            $cookies = \Yii::$app->request->cookies;
            $value = $cookies->getValue('carts');
            if ($value) {
                $carts = unserialize($value);
            } else {
                $carts = [];
            }
            if (array_key_exists($goods_id, $carts)) {
                $carts[$goods_id] += $count;
            } else {
                $carts[$goods_id] = $count;
            }
            //  $carts = unserialize($value);
            //将购物车数据保存到cookie
            $cookie = new Cookie();
            $cookie->name = 'carts';
            $cookie->value = serialize($carts);
            $cookie->expire = 10 * 3600 * 24 + time();
            $cookies = \Yii::$app->response->cookies;
            $cookies->add($cookie);

        } else {
            $request = \Yii::$app->request;
            $model = new Cart();
            $carts = Cart::findOne(['goods_id' => $goods_id]);
            if ($carts) {
                $carts->count = $carts->count + $count;
                $carts->save();
            } else {
                $model->load($request->get(), '');
                if ($model->validate()) {
                    $model->user_id = \Yii::$app->user->id;
                    $model->save();
                }
            }
        }
        return $this->render('success');
    }

    public function actionCart()
    {
        if (\Yii::$app->user->isGuest) {
            $cookie = \Yii::$app->request->cookies;
            $cart = $cookie->getValue('carts');
            //var_dump($cart);exit;
            if ($cart) {
                $carts = unserialize($cart);
            }
            else {
                $carts = [];
            }
        } else{
            $cts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();

//            var_dump($carts);exit;
            $carts = [];
            foreach ($cts as $cart){
                $carts[$cart['goods_id']]=$cart['count'];
            }

        }
        return $this->render('cart', ['carts' => $carts]);
    }
    public function actionDelete($goods_id,$amount){

        if (\Yii::$app->user->isGuest){
            $cookies = \Yii::$app->request->cookies;
            $value = $cookies->getValue('carts');
            //判断cookie里是否存在此商品
            if($value){
                $carts = unserialize($value);
            }else{
                $carts = [];
            }
            //如果购物车存在该商品,则改变改商品
            if($amount){
                $carts[$goods_id] = $amount;
            }else{
                //如果没有该商品则删除该商品
                unset($carts[$goods_id]);
                $cookie = new Cookie();
                $cookie->name = 'carts';
                $cookie->value = serialize($carts);
                $cookie->expire = 10*24*3600+time();
                $cookies = \Yii::$app->response->cookies;
                $cookies->add($cookie);
                return 'success';
            }
            //将购物车数据保存到cookie
            $cookie = new Cookie();
            $cookie->name = 'carts';
            $cookie->value = serialize($carts);
            $cookie->expire = 10*24*3600+time();
            $cookies = \Yii::$app->response->cookies;
            $cookies->add($cookie);
        }else{
            //实例化request组件
            $request = \Yii::$app->request;
            //实例化数据表
//            $model = new Cart();
            $carts = Cart::findOne(['goods_id'=>$goods_id]);
            if ($amount){
                $carts->count = $amount;
                $carts->save(0);

            }else{
                $carts->delete();
                return 'success';
            }

        }
    }
    public function actionFlow2(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['member/login']);
        }else{
           // var_dump($id);exit;
            $delivery=Delivery::find()->all();
            $payment=Payment::find()->all();
            $model=Address::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
            $cts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
//            var_dump($carts);exit;
            $carts = [];
            foreach ($cts as $cart){
                $carts[$cart['goods_id']]=$cart['count'];}
            return $this->render('flow2',['model'=>$model,'carts'=>$carts,'delivery'=>$delivery,'payment'=>$payment]);
        }
    }
public function actionOrder(){
       // var_dump($_GET);exit;
        $request=\Yii::$app->request;
                if($request->isPost) {
                    $order=new Order();
                    $payment_id=$_POST['payment_id'];
                    $address_id=$_POST['address_id'];
                    $delivery_id=$_POST['delivery_id'];
                    $payment=Payment::findOne(['payment_id'=>$payment_id]);
                    $address=Address::findOne(['id'=>$address_id]);
                    $delivery=Delivery::findOne(['delivery_id'=>$delivery_id]);
                        $order->member_id = \Yii::$app->user->id;
                        $order->name = $address->username;
                        $order->province = $address->provence;
                        $order->city = $address->city;
                        $order->area = $address->area;
                        $order->address = $address->address;
                        $order->tel = $address->tel;
                        $order->delivery_id = $delivery->delivery_id;
                        $order->delivery_price = $delivery->delivery_price;
                        $order->delivery_name = $delivery->delivery_name;
                        $order->payment_id = $payment->payment_id;
                        $order->payment_name = $payment->payment_name;
                        $order->create_time=time();
                        $order->total = 0;
                        $transaction = \Yii::$app->db->beginTransaction();
                        try{
                            $order->save();
                            $carts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
                            //var_dump($carts);exit;
                            foreach ($carts as $cart){
                                $goods  = Goods::findOne(['id'=>$cart->goods_id]);
                               // var_dump($goods);exit;
                                if($goods->stock < $cart->count){
                                    throw new Exception('['.$goods->name.']没得了');
                                }
                                /*$goods->stock -= $cart->count;
                                $goods->save();*/
                                $orderGoods = new OrderGoods();
                                $orderGoods->order_id = $order->id;
                                $orderGoods->goods_id = $goods->id;
                                $orderGoods->goods_name = $goods->name;
                                $orderGoods->logo=$goods->logo;
                                $orderGoods->price=$goods->shop_price;
                                $orderGoods->amount=$cart->count;
                                $orderGoods->total = $goods->shop_price*$cart->count;
                                $orderGoods->save();
                                Cart::deleteAll(['user_id'=>\Yii::$app->user->id]);

                            }
                            $transaction->commit();

                        }
                        catch (Exception $e) {
                            $transaction->rollBack();
                        }
                };
    return $this->render('flow3');
}
            public function actionFlow3(){

                return $this->render('flow3');
            }
            public function actionOrderList(){
                $id=\Yii::$app->user->id;
                $order=Order::find()->where(['member_id'=>$id])->limit(3)->asArray()->all();
               // var_dump($order);exit;
                return $this->render('order',['order'=>$order]);
            }
}


<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Goods".
 *
 * @property int $id
 * @property string $name 商品名称
 * @property string $sn 货号
 * @property string $logo logo图片
 * @property int $goods_category_id 商品分类id
 * @property int $brand_id 品牌分类
 * @property string $market_price 市场价格
 * @property string $shop_price 商品价格
 * @property int $stock 库存
 * @property int $in_on_sale 状态
 * @property int $sort 排序
 * @property int $create_time 添加时间
 * @property int $vies_times 浏览次数
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale','sort','status'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 100],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => 'logo图片',
            'goods_category_id' => '商品分类id',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'sort' => '排序',
            'status'=>'状态'
        ];
    }
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'goods_category_id']);
    }
    public function getBrands(){
        $rows =Brand::find()->all();
        $res=[];
        foreach($rows as $row){
            $res[$row->id]=$row->name;
        };
        return $res;
    }
}

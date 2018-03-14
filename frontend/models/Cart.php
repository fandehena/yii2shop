<?php

namespace frontend\models;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $goods_id 商品id
 * @property int $count 商品数量
 * @property int $user_id 用户id
 */
class Cart extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'count', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'count' => '商品数量',
            'user_id' => '用户id',
        ];
    }
}
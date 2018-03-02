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
            [['goods_category_id', 'brand_id', 'stock', 'in_on_sale', 'sort', 'create_time', 'vies_times'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 20],
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
            'in_on_sale' => '状态',
            'sort' => '排序',
            'create_time' => '添加时间',
            'vies_times' => '浏览次数',
        ];
    }
}

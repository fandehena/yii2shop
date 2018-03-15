<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_gallery".
 *
 * @property int $id
 * @property int $goods_id 商品id
 * @property string $path 图片地址
 */
class GoodsGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imgFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
            ['imgFile','file','extensions' => ['png', 'jpg', 'gif'],'skipOnEmpty'=>1],
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
            'inmFile' => '图片地址',
        ];
    }
}

<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_intro".
 *
 * @property int $goods_id 商品id
 * @property string $content 商品描述
 */
class GoodsIntro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => '商品id',
            'content' => '商品描述',
        ];
    }
}

<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "Brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $is_deleted
 */
class Brand extends ActiveRecord
{
    /**
     * @inheritdoc
     */
   // public $imgFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['logo'],'required'],
            [['intro'], 'string'],
            [['sort', 'is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            'logo' => 'LOGO图片',
            'sort' => '排序',
            'is_deleted' => '状态',
        ];
    }
}

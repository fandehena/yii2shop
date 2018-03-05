<?php
namespace backend\models;

use Yii;
use yii\base\Model;
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
class ResetForm extends Model
{
/**
* @inheritdoc
*/
// public $imgFile;

/**
* @inheritdoc
*/
public $passwords;
public function rules()
{
return [
['password','required']
];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
'passwords'=>'重置密码'
];
}
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/9 0009
 * Time: 15:52
 */

namespace app\models;


use yii\base\Model;
use yii\db\ActiveRecord;

class Address extends ActiveRecord
{
  // public $username;
    public $cmbProvince;
    public $cmbCity;
    public $cmbArea;

public function rules()
{
        return [
            [['username','cmbArea','cmbProvince','cmbCity'],'required'],
           // [['province','city','area'],'required'],
            ['status','safe'],
            ['address','required'],
            ['tel','required']
        ];
}
public function attributeLabels()
{
    return[
        'username'=>'收货人',
        'address'=>'详细地址',
        'cmbProvince'=>'省',
        'cmbCity'=>'城市',
        'cmbArea'=>'区',
        'tel'=>'电话号码',
//        'province'=>'省',
//        'city'=>'城市',
//        'area'=>'区',
    ];
}
}
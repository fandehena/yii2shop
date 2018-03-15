<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id id
 * @property string $name 菜单名称
 * @property string $menu 上级菜单
 * @property string $url 路由
 * @property int $port 排序
 */
class Menu extends \yii\db\ActiveRecord
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
            [['name', 'url', 'port'], 'required'],
            [['port','parent_id'], 'integer'],
            [['name', 'menu', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => '菜单名称',
            'menu' => '上级菜单',
            'url' => '路由',
            'port' => '排序',
            'parent_id' => '顶级分类',
        ];
    }

    public function getPermission()
    {
        $authManager = \Yii::$app->authManager;
        return $this->hasOne($authManager->getPermissions(),[]);
    }

    public static function getPermissions()
    {
        $authManager = \Yii::$app->authManager;
        $rows = $authManager->getPermissions();
       // $res = [];
        $res=['==请选择路由=='];
        foreach ($rows as $row) {
            $res[$row->name] = $row->name;
        };
        return $res;
    }
    public static function getMenus($menuItems){
        $menus=self::find()->where(['parent_id'=>0])->all();
        foreach($menus as $menu){
            $items=[];
            $children=self::find()->where(['parent_id'=>$menu->id])->all();
            foreach ($children as $child){
                if(\Yii::$app->user->can($child->url))
                $items[]=['label'=>$child->name,'url'=>[$child->url]];
            }
            if(!empty($items))
            $menuItems[] = ['label' =>$menu->name,'items'=> $items];
        }
        return $menuItems;
    }
}
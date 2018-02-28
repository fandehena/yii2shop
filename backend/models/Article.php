<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27 0027
 * Time: 15:33
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Article extends ActiveRecord
{
public function attributeLabels()
{
    return [
        'id' => 'ID',
        'name' => '名称',
        'intro'=>'简介',
        'article_category_id'=>'文章分类id',
        'sort' => '排序',
        'is_deleted' => '状态',
        'create_time'=>'创建时间',
    ];
}
public function rules()
{
    return [
        [['article_category_id'],'required'],
        [['intro'], 'string'],
        [['sort', 'is_deleted'], 'integer'],
        [['name'], 'string', 'max' => 5],
    ];
}
    public function getArticleCategory(){
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
    public function getArticles(){
        $rows =ArticleCategory::find()->all();
        $res=[];
        foreach($rows as $row){
            $res[$row->id]=$row->name;
        };
        return $res;
    }
}
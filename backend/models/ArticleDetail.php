<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27 0027
 * Time: 18:51
 */

namespace backend\models;



use yii\db\ActiveRecord;

class ArticleDetail extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'article_id' => 'ID',
            'content' => '内容',
        ];
    }
    public function rules()
    {
        return [
            [['article_id','content'],'required'],
        ];
    }

}
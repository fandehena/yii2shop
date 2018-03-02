<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_detail`.
 */
class m180227_082942_create_article_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_detail', [
            'article_id' => $this->primaryKey()->comment('文章ID'),
            'content'=>$this->text()->comment('简介')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_detail');
    }
}

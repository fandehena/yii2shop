<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m180228_135449_create_goods_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->comment('树ID'),
            'lft' => $this->integer()->comment('左值'),
            'rgt' => $this->integer()->comment('右值'),
            'depth' => $this->integer()->comment('层级'),
            'name' => $this->char(50)->comment('名称'),
            'parent_id' => $this->integer()->comment('上级分类id'),
            'intro' => $this->integer()->comment('简介'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_category');
    }
}

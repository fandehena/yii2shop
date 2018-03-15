<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m180308_060538_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->createTable('menu', [
                'id' => $this->primaryKey()->comment('id'),
                'name'=>$this->char(255)->notNull()->comment('菜单名称'),
                'menu'=>$this->char(255)->notNull()->comment('上级菜单'),
                'url'=>$this->char(255)->notNull()->comment('路由'),
                'port'=>$this->integer(11)->notNull()->comment('排序'),
                'parent_id' => $this->integer()->comment('上级分类id'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('menu');
    }
}

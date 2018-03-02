<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m180226_084929_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name' => $this->char(5)->comment('名称'),
            'intro'=>$this->text()->comment('简介'),
            'logo'=>$this->char(255)->comment('LOGO图片'),
            'sort'=>$this->integer(11)->comment('排序'),
            'is_deleted'=>$this->integer(1)->comment('状态')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}

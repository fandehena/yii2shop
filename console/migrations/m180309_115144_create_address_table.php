<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m180309_115144_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->comment("收货人"),
            'provence' => $this->string()->notNull()->comment("省"),
            'city' => $this->string()->notNull()->comment("市"),
            'area' => $this->string()->notNull()->comment("区"),
            'address' => $this->string()->notNull()->comment("详细地址"),
            'tel' => $this->string(11)->notNull()->comment("手机号"),
            'status' => $this->string()->notNull()->comment("状态(是否为默认地址)"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('address');
    }
}

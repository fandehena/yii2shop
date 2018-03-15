<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_goods`.
 */
class m180314_064144_create_order_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_goods', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->comment('订单id'),
            'goods_id' => $this->integer()->comment('商品id'),
            'goods_name' => $this->string()->comment('商品名称'),
            'logo' => $this->string()->comment('商品图片'),
            'price' => $this->decimal()->comment('商品价格'),
            'amount' => $this->integer()->comment('商品数量'),
            'total' => $this->decimal()->comment('小计'),
        ], $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_goods');
    }
}

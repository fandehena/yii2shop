<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180314_031625_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id' => $this->integer()->comment('用户id'),
            'name' => $this->string()->comment('收货人'),
            'province' => $this->string()->comment('省'),
            'city' => $this->string()->comment('市'),
            'area' => $this->string()->comment('区'),
            'address' => $this->string()->comment('收货地址'),
            'tel' => $this->char(11)->comment('电话号码'),
            'delivery_id' => $this->integer()->comment('配送方式id'),
            'delivery_name' => $this->string()->comment('配送方式名称'),
            'delivery_price' => $this->float()->comment('配送方式价格'),
            'payment_id' => $this->string()->comment('支付方式id'),
            'payment_name' => $this->string()->comment('支付方式名称'),
            'total' => $this->string()->comment('订单金额'),
            'status' => $this->integer()->comment('订单状态（0已取消1待付款2待发货3待收货4完成）'),
            'trade_no'=>$this->string()->comment('第三方支付交易号'),
            'create_time'=>$this->integer()->comment('创建时间'),
        ], $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }
}

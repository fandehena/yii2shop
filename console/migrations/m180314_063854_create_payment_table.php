<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m180314_063854_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'payment_id' => $this->integer()->comment('支付方式id'),
            'payment_name' => $this->string()->comment('支付方式名称'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('payment');
    }
}

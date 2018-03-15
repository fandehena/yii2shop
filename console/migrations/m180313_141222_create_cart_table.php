<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m180313_141222_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->string()->comment('用户ID'),
            'goods_id'=>$this->string()->comment('商品ID'),
            'count'=>$this->string()->comment('商品个数'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cart');
    }
}

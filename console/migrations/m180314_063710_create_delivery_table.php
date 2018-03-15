<?php

use yii\db\Migration;

/**
 * Handles the creation of table `delivery`.
 */
class m180314_063710_create_delivery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('delivery', [
            'id' => $this->primaryKey(),
            'delivery_id' => $this->integer()->comment('配送方式id'),
            'delivery_name' => $this->string()->comment('配送方式价格'),
            'delivery_price' => $this->string()->comment('配送方式价格'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('delivery');
    }
}

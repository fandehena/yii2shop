<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_day_count`.
 */
class m180228_144655_create_goods_day_count_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_day_count', [
            'day' => $this->date()->comment('日期'),
            'count' => $this->integer()->comment('商品数'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_day_count');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m180228_144906_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name' => $this->char(20)->comment('商品名称'),
            'sn'=>$this->char(20)->comment('货号'),
            'logo'=>$this->char(255)->comment('logo图片'),
            'goods_category_id'=>$this->integer()->comment('商品分类id'),
            'brand_id'=>$this->integer()->comment('品牌分类'),
            'market_price'=>$this->decimal(10,2)->comment('市场价格'),
            'shop_price'=>$this->decimal(10,2)->comment('商品价格'),
            'stock'=>$this->integer()->comment('库存'),
            'in_on_sale'=>$this->integer()->comment('状态'),
            'sort'=>$this->integer()->comment('排序'),
            'create_time'=>$this->integer()->comment('添加时间'),
            'vies_times'=>$this->integer()->comment('浏览次数'),
        ], $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods');
    }
}

<?php

use yii\db\Migration;

/**
 * Class m180310_012053_add_user_id_to_address
 */
class m180310_012053_add_user_id_to_address extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('address','user_id','integer default 0');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180310_012053_add_user_id_to_address cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180310_012053_add_user_id_to_address cannot be reverted.\n";

        return false;
    }
    */
}

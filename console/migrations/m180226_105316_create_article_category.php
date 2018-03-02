<?php

use yii\db\Migration;

/**
 * Class m180226_105316_create_article_category
 */
class m180226_105316_create_article_category extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180226_105316_create_article_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180226_105316_create_article_category cannot be reverted.\n";

        return false;
    }
    */
}

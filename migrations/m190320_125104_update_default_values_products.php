<?php

use yii\db\Migration;

/**
 * Class m190320_125104_update_default_values_products
 */
class m190320_125104_update_default_values_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("yy_products","count_reviews", $this->integer(11)->defaultValue(0));
        $this->alterColumn("yy_products","avg_rank", $this->integer(11)->defaultValue(0));
        $this->alterColumn("yy_products","status", $this->integer(11)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190320_125104_update_default_values_products cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190320_125104_update_default_values_products cannot be reverted.\n";

        return false;
    }
    */
}

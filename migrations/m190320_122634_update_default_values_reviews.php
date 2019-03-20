<?php

use yii\db\Migration;

/**
 * Class m190320_122634_update_default_values_reviews
 */
class m190320_122634_update_default_values_reviews extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('yy_reviews','img_main',$this->string(255)->defaultValue('image/no_product.png'));
        $this->alterColumn('yy_reviews','views',$this->integer(11)->defaultValue(0));
        $this->alterColumn('yy_reviews','likes',$this->integer(8)->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190320_122634_update_default_values_reviews cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190320_122634_update_default_values_reviews cannot be reverted.\n";

        return false;
    }
    */
}

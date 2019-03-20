<?php

use yii\db\Migration;

/**
 * Class m190320_131322_update_default_values_reviews_sub_image
 */
class m190320_131322_update_default_values_reviews_sub_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("yy_reviews_subimage", "sort", $this->integer(8)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190320_131322_update_default_values_reviews_sub_image cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190320_131322_update_default_values_reviews_sub_image cannot be reverted.\n";

        return false;
    }
    */
}

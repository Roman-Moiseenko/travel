<?php

use yii\db\Migration;

/**
 * Class m200830_232709_add_booking_tours_reviews_field
 */
class m200830_232709_add_booking_tours_reviews_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_reviews}}', 'status', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200830_232709_add_booking_tours_reviews_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200830_232709_add_booking_tours_reviews_field cannot be reverted.\n";

        return false;
    }
    */
}

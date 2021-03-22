<?php

use yii\db\Migration;

/**
 * Class m210322_181616_add_booking_stays_reviews_status_field
 */
class m210322_181616_add_booking_stays_reviews_status_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_reviews}}', 'status', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210322_181616_add_booking_stays_reviews_status_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210322_181616_add_booking_stays_reviews_status_field cannot be reverted.\n";

        return false;
    }
    */
}

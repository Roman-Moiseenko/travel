<?php

use yii\db\Migration;

/**
 * Class m201113_091727_add_booking_cars_discount_of_days_field
 */
class m201113_091727_add_booking_cars_discount_of_days_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_cars}}', 'discount_of_days', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_cars}}', 'discount_of_days');
    }

}

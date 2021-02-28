<?php

use yii\db\Migration;

/**
 * Class m210228_173146_add_booking_stays_city_field
 */
class m210228_173146_add_booking_stays_city_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays}}', 'city', $this->string());
        $this->createIndex('{{%idx-booking_stays-city}}', '{{%booking_stays}}', 'city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays}}', 'city');
        $this->dropIndex('{{%idx-booking_stays-city}}', '{{%booking_stays}}');
    }

}

<?php

use yii\db\Migration;

/**
 * Class m210319_101951_add_bookings_filling_field
 */
class m210319_101951_add_bookings_filling_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours}}', 'filling', $this->integer());
        $this->addColumn('{{%booking_cars}}', 'filling', $this->integer());
        $this->addColumn('{{%booking_funs}}', 'filling', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours}}', 'filling');
        $this->dropColumn('{{%booking_cars}}', 'filling');
        $this->dropColumn('{{%booking_funs}}', 'filling');
    }

}

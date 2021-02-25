<?php

use yii\db\Migration;

/**
 * Class m210219_133549_add_booking_stays_filling_field
 */
class m210219_133549_add_booking_stays_filling_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays}}', 'filling', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays}}', 'filling');
    }

}

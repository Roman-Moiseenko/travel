<?php

use yii\db\Migration;

/**
 * Class m210311_125559_add_booking_tours_meta_feild
 */
class m210311_125559_add_booking_tours_meta_feild extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours}}', 'meta_json', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours}}', 'meta_json');
    }

}

<?php

use yii\db\Migration;

/**
 * Class m210311_130217_add_booking_meta_feild
 */
class m210311_130217_add_booking_meta_feild extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays}}', 'meta_json', $this->text());
        $this->addColumn('{{%booking_cars}}', 'meta_json', $this->text());
        $this->addColumn('{{%booking_funs}}', 'meta_json', $this->text());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays}}', 'meta_json');
        $this->dropColumn('{{%booking_cars}}', 'meta_json');
        $this->dropColumn('{{%booking_funs}}', 'meta_json');
    }

}

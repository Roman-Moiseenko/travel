<?php

use yii\db\Migration;

/**
 * Class m210309_140020_add_booking_object_photos_alt_fields
 */
class m210309_140020_add_booking_object_photos_alt_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_photos}}', 'alt', $this->string());
        $this->addColumn('{{%booking_cars_photos}}', 'alt', $this->string());
        $this->addColumn('{{%booking_funs_photos}}', 'alt', $this->string());
        $this->addColumn('{{%booking_stays_photos}}', 'alt', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_photos}}', 'alt');
        $this->dropColumn('{{%booking_cars_photos}}', 'alt');
        $this->dropColumn('{{%booking_funs_photos}}', 'alt');
        $this->dropColumn('{{%booking_stays_photos}}', 'alt');
    }


}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stay_bed_type}}`.
 */
class m210217_201248_create_booking_stay_bed_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stay_bed_type}}', [
            'id' => $this->primaryKey(),
            'name' =>$this->string(),
            'count' => $this->integer()->notNull()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stay_bed_type}}');
    }
}

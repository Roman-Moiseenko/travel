<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stay_rooms_assign}}`.
 */
class m210217_201240_create_booking_stay_rooms_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stay_rooms_assign}}', [
            'id' => $this->primaryKey(),
            'stay_id' => $this->integer()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(1),
        ]);

        $this->createIndex('{{%idx-booking_stay_rooms_assign-stay_id}}', '{{%booking_stay_rooms_assign}}', 'stay_id');
        $this->addForeignKey(
            '{{%fk-booking_stay_rooms_assign-stay_id}}',
            '{{%booking_stay_rooms_assign}}',
            'stay_id',
            '{{%booking_stays}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stay_rooms_assign}}');
    }
}

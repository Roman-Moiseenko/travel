<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_placement_type}}`.
 */
class m210623_204838_create_booking_trips_placement_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_placement_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_placement_type}}');
    }
}

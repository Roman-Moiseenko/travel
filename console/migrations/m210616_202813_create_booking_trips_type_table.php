<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_type}}`.
 */
class m210616_202813_create_booking_trips_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'sort' => $this->integer()->defaultValue(0)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_type}}');
    }
}

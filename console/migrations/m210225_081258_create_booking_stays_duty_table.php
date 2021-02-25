<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_duty_type}}`.
 */
class m210225_081258_create_booking_stays_duty_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays_duty}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_duty}}');
    }
}

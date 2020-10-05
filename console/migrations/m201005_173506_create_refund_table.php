<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%refund}}`.
 */
class m201005_173506_create_refund_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%refund}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'refund_at' => $this->integer(),
            'booking_id' => $this->integer(),
            'class_booking' => $this->string(),
            'amount' => $this->float(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%refund}}');
    }
}

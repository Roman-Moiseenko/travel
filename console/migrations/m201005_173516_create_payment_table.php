<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment}}`.
 */
class m201005_173516_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'payment_at' => $this->integer(),
            'booking_id' => $this->integer(),
            'legal_id' => $this->integer(),
            'class_booking' => $this->string(),
            'amount' => $this->float(),
            'pay_legal' => $this->float()->defaultValue(0),
            'status' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-payment-dialog_id}}', '{{%payment}}', 'legal_id');
        $this->addForeignKey('{{%fk-payment-dialog_id}}', '{{%payment}}', 'legal_id',
            '{{%admin_user_legals}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment}}');
    }
}

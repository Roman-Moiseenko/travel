<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_tour_transfer}}`.
 */
class m210614_135530_create_users_tour_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_tour_transfer}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'from_id' => $this->integer()->notNull(),
            'to_id' => $this->integer()->notNull(),
            'cost' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-users_tour_transfer-user_id}}', '{{%users_tour_transfer}}', 'user_id');
        $this->addForeignKey('{{%fk-users_tour_transfer-user_id}}', '{{%users_tour_transfer}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-users_tour_transfer-from_id}}', '{{%users_tour_transfer}}', 'from_id');
        $this->addForeignKey('{{%fk-users_tour_transfer-from_id}}', '{{%users_tour_transfer}}', 'from_id', '{{%booking_service_city}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-users_tour_transfer-to_id}}', '{{%users_tour_transfer}}', 'to_id');
        $this->addForeignKey('{{%fk-users_tour_transfer-to_id}}', '{{%users_tour_transfer}}', 'to_id', '{{%booking_service_city}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_tour_transfer}}');
    }
}

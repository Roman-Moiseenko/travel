<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_tour_capacity}}`.
 */
class m210613_181855_create_users_tour_capacity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_tour_capacity}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'percent' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-users_tour_capacity-user_id}}', '{{%users_tour_capacity}}', 'user_id');
        $this->addForeignKey(
            '{{%fk-users_tour_capacity-user_id}}',
            '{{%users_tour_capacity}}',
            'user_id',
            '{{%admin_users}}',
            'id',
            'CASCADE',
            'RESTRICT'
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_tour_capacity}}');
    }
}

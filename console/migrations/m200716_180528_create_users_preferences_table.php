<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_preferences}}`.
 */
class m200716_180528_create_users_preferences_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_preferences}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'smocking' => $this->boolean(),
            'lang' => $this->string(2),
            'currency' =>$this->string(4)
        ]);

        $this->createIndex('{{%idx-users_preferences-user_id}}', '{{%users_preferences}}', 'user_id');

        $this->addForeignKey('{{%fk-users_preferences-user_id}}', '{{%users_preferences}}', 'user_id', '{{%users}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_preferences}}');
    }
}

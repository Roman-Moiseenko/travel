<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_preferences}}`.
 */
class m200716_180528_create_user_preferences_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_preferences}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'smocking' => $this->boolean(),
            'lang' => $this->string(2),
            'currency' =>$this->string(4)
        ]);

        $this->createIndex('{{%idx-user_preferences-user_id}}', '{{%user_preferences}}', 'user_id');

        $this->addForeignKey('{{%fk-user_preferences-user_id}}', '{{%user_preferences}}', 'user_id', '{{%users}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_preferences}}');
    }
}

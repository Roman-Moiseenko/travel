<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_notice}}`.
 */
class m200826_152431_create_admin_user_notice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%admin_user_notice}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'notice' => $this->text(),

        ], $tableOptions);

        $this->createIndex('{{%idx-admin_user_notice-user_id}}', '{{%admin_user_notice}}', 'user_id');
        $this->addForeignKey('{{%fk-admin_user_notice-user_id}}', '{{%admin_user_notice}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user_notice}}');
    }
}

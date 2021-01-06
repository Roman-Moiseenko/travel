<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_legal_certs}}`.
 */
class m210105_204419_create_admin_user_legal_certs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%admin_user_legal_certs}}', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'name' => $this->string(),
            'issue_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-admin_user_legal_certs-legal_id}}', '{{%admin_user_legal_certs}}', 'legal_id');
        $this->addForeignKey('{{%fk-admin_user_legal_certs-legal_id}}', '{{%admin_user_legal_certs}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user_legal_certs}}');
    }
}

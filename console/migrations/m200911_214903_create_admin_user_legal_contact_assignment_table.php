<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_legal_contact_assignment}}`.
 */
class m200911_214903_create_admin_user_legal_contact_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_user_legal_contact_assignment}}', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer(),
            'contact_id' => $this->integer(),
            'value' => $this->string(),
            'description' => $this->string()
        ]);

        $this->createIndex('{{%idx-admin_user_legal_contact_assignment-legal_id}}', '{{%admin_user_legal_contact_assignment}}', 'legal_id');
        $this->createIndex('{{%idx-admin_user_legal_contact_assignment-contact_id}}', '{{%admin_user_legal_contact_assignment}}', 'contact_id');

        $this->addForeignKey('{{%fk-admin_user_legal_contact_assignment-legal_id}}', '{{%admin_user_legal_contact_assignment}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-admin_user_legal_contact_assignment-contact_id}}', '{{%admin_user_legal_contact_assignment}}', 'contact_id', '{{%admin_user_legal_contact}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user_legal_contact_assignment}}');
    }
}

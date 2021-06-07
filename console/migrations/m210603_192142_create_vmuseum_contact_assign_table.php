<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vmuseum_contact_assign}}`.
 */
class m210603_192142_create_vmuseum_contact_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vmuseum_contact_assign}}', [
            'vmuseum_id' => $this->integer(),
            'contact_id' => $this->integer(),
            'value'=> $this->string(),
            'description'=> $this->string()
        ]);

        $this->addPrimaryKey('{{%pk-vmuseum_contact_assign}}', '{{%vmuseum_contact_assign}}', ['vmuseum_id', 'contact_id']);

        $this->createIndex('{{%idx-vmuseum_contact_assign-vmuseum_id}}', '{{%vmuseum_contact_assign}}', 'vmuseum_id');
        $this->createIndex('{{%idx-vmuseum_contact_assign-contact_id}}', '{{%vmuseum_contact_assign}}', 'contact_id');

        $this->addForeignKey(
            '{{%fk-vmuseum_contact_assign-vmuseum_id}}',
            '{{%vmuseum_contact_assign}}',
            'vmuseum_id',
            '{{%vmuseum}}',
            'id',
            'CASCADE',
            'RESTRICT');
        $this->addForeignKey(
            '{{%fk-vmuseum_contact_assign-contact_id}}',
            '{{%vmuseum_contact_assign}}',
            'contact_id',
            '{{%admin_user_legal_contact}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vmuseum_contact_assign}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%foods_contact_assign}}`.
 */
class m210329_091941_create_foods_contact_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%foods_contact_assign}}', [
            'food_id' => $this->integer(),
            'contact_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('{{%pk-foods_contact_assign}}', '{{%foods_contact_assign}}', ['food_id', 'contact_id']);

        $this->createIndex('{{%idx-foods_contact_assign-food_id}}', '{{%foods_contact_assign}}', 'food_id');
        $this->createIndex('{{%idx-foods_contact_assign-contact_id}}', '{{%foods_contact_assign}}', 'contact_id');

        $this->addForeignKey(
            '{{%fk-foods_contact_assign-food_id}}',
            '{{%foods_contact_assign}}',
            'food_id',
            '{{%foods}}',
            'id',
            'CASCADE',
            'RESTRICT');
        $this->addForeignKey(
            '{{%fk-foods_contact_assign-contact_id}}',
            '{{%foods_contact_assign}}',
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
        $this->dropTable('{{%foods_contact_assign}}');
    }
}

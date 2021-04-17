<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_contact_assign}}`.
 */
class m210417_003638_create_shops_contact_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_contact_assign}}', [
            'shop_id' => $this->integer(),
            'contact_id' => $this->integer(),
            'value'=> $this->string(),
            'description'=> $this->string()
        ]);

        $this->addPrimaryKey('{{%pk-shops_contact_assign}}', '{{%shops_contact_assign}}', ['shop_id', 'contact_id']);

        $this->createIndex('{{%idx-shops_contact_assign-shop_id}}', '{{%shops_contact_assign}}', 'shop_id');
        $this->createIndex('{{%idx-shops_contact_assign-contact_id}}', '{{%shops_contact_assign}}', 'contact_id');

        $this->addForeignKey(
            '{{%fk-shops_contact_assign-shop_id}}',
            '{{%shops_contact_assign}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE',
            'RESTRICT');
        $this->addForeignKey(
            '{{%fk-shops_contact_assign-contact_id}}',
            '{{%shops_contact_assign}}',
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
        $this->dropTable('{{%shops_contact_assign}}');
    }
}

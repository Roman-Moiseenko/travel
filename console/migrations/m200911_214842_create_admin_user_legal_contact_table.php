<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_legal_contact}}`.
 */
class m200911_214842_create_admin_user_legal_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_user_legal_contact}}', [
            'id' => $this->primaryKey(),
            'photo' => $this->string(),
            'name' => $this->string(),
            'type' => $this->integer()->defaultValue(0),
            'prefix' => $this->string()->defaultValue(''),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user_legal_contact}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_legals}}`.
 */
class m200721_221636_create_admin_user_legals_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_user_legals}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'INN' => $this->string(),
            'KPP' => $this->string(),
            'OGRN' => $this->string(),
            'BIK' => $this->string(),
            'account' => $this->string(),
        ]);
        $this->createIndex('{{%idx-admin_user_legals-user_id}}', '{{%admin_user_legals}}', 'user_id');
        $this->addForeignKey('{{%fk-admin_user_legals-user_id}}', '{{%admin_user_legals}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user_legals}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Class m200922_211823_change_auth_assignments_table
 */
class m200922_211823_change_auth_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%auth_assignments}}', 'user_id', $this->integer()->notNull());
        $this->createIndex('{{%idx-auth_assignments-user_id}}', '{{%auth_assignments}}', 'user_id');
        $this->addForeignKey('{{%fk-auth_assignments-user_id}}', '{{%auth_assignments}}', 'user_id', '{{%office_users}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-auth_assignments-user_id}}', '{{%auth_assignments}}');
        $this->dropIndex('{{%idx-auth_assignments-user_id}}', '{{%auth_assignments}}');
        $this->alterColumn('{{%auth_assignments}}', 'user_id', $this->string(64)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200922_211823_change_auth_assignments_table cannot be reverted.\n";

        return false;
    }
    */
}

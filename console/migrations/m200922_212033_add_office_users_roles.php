<?php

use yii\db\Migration;

/**
 * Class m200922_212033_add_office_users_roles
 */
class m200922_212033_add_office_users_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //TODO ДОБАВИТЬ РОЛИ !!!!!!!!!!!!!!!!
        $this->batchInsert('{{%auth_items}}', ['type', 'name', 'description'], [
            [1, 'support', 'Поддержка'],
            [1, 'manager', 'Менеджер'],
            [1, 'admin', 'Админ'],
        ]);

        $this->batchInsert('{{%auth_item_children}}', ['parent', 'child'], [
            ['admin', 'manager'],
            ['manager', 'support'],
        ]);

        $this->execute('INSERT INTO {{%auth_assignments}} (item_name, user_id) SELECT \'admin\', u.id FROM {{%office_users}} u ORDER BY u.id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%auth_items}}', ['name' => ['support', 'manager', 'admin']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200922_212033_add_office_users_roles cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m201013_152126_add_new_role_office_user
 */
class m201013_152126_add_new_role_office_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%auth_items}}', ['type', 'name', 'description'], [
            [1, 'blogger', 'Блогер'],
        ]);

        $this->batchInsert('{{%auth_item_children}}', ['parent', 'child'], [
            ['support', 'blogger'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201013_152126_add_new_role_office_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201013_152126_add_new_role_office_user cannot be reverted.\n";

        return false;
    }
    */
}

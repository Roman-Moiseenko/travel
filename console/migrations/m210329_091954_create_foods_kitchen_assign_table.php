<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%foods_kitchen_assign}}`.
 */
class m210329_091954_create_foods_kitchen_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%foods_kitchen_assign}}', [
            'food_id' => $this->integer(),
            'kitchen_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('{{%pk-foods_kitchen_assign}}', '{{%foods_kitchen_assign}}', ['food_id', 'kitchen_id']);

        $this->createIndex('{{%idx-foods_kitchen_assign-food_id}}', '{{%foods_kitchen_assign}}', 'food_id');
        $this->createIndex('{{%idx-foods_kitchen_assign-kitchen_id}}', '{{%foods_kitchen_assign}}', 'kitchen_id');

        $this->addForeignKey(
            '{{%fk-foods_kitchen_assign-food_id}}',
            '{{%foods_kitchen_assign}}',
            'food_id',
            '{{%foods}}',
            'id',
            'CASCADE',
            'RESTRICT');
        $this->addForeignKey(
            '{{%fk-foods_kitchen_assign-kitchen_id}}',
            '{{%foods_kitchen_assign}}',
            'kitchen_id',
            '{{%foods_kitchen}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%foods_kitchen_assign}}');
    }
}

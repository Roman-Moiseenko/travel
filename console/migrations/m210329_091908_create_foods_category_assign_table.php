<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%foods_category_assign}}`.
 */
class m210329_091908_create_foods_category_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%foods_category_assign}}', [
            'food_id' => $this->integer(),
            'category_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('{{%pk-foods_category_assign}}', '{{%foods_category_assign}}', ['food_id', 'category_id']);

        $this->createIndex('{{%idx-foods_category_assign-food_id}}', '{{%foods_category_assign}}', 'food_id');
        $this->createIndex('{{%idx-foods_category_assign-category_id}}', '{{%foods_category_assign}}', 'category_id');

        $this->addForeignKey(
            '{{%fk-foods_category_assign-food_id}}',
            '{{%foods_category_assign}}',
            'food_id',
            '{{%foods}}',
            'id',
            'CASCADE',
            'RESTRICT');
        $this->addForeignKey(
            '{{%fk-foods_category_assign-category_id}}',
            '{{%foods_category_assign}}',
            'category_id',
            '{{%foods_category}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%foods_category_assign}}');
    }
}

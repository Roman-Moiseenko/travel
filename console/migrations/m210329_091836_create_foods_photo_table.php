<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%foods_photo}}`.
 */
class m210329_091836_create_foods_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%foods_photo}}', [
            'id' => $this->primaryKey(),
            'food_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-foods_photo-food_id}}', '{{%foods_photo}}', 'food_id');
        $this->addForeignKey(
            '{{%fk-foods_photo-food_id}}',
            '{{%foods_photo}}',
            'food_id',
            '{{%foods}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%foods_photo}}');
    }
}

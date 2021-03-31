<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%foods_reviews}}`.
 */
class m210329_100600_create_foods_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%foods_reviews}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'vote' => $this->integer()->notNull(),
            'text' => $this->string(),
            'username' => $this->string(),
            'email' => $this->string(),
            'food_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-foods_reviews-food_id}}', '{{%foods_reviews}}', 'food_id');
        $this->addForeignKey(
            '{{%fk-foods_reviews-food_id}}',
            '{{%foods_reviews}}',
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
        $this->dropTable('{{%foods_reviews}}');
    }
}

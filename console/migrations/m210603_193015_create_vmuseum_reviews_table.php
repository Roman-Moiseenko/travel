<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vmuseum_reviews}}`.
 */
class m210603_193015_create_vmuseum_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%vmuseum_reviews}}', [
            'id' => $this->primaryKey(),
            'vmuseum_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'vote' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->integer()->defaultValue(1)
        ], $tableOptions);
        $this->createIndex('{{%idx-vmuseum_reviews-user_id}}', '{{%vmuseum_reviews}}', 'user_id');
        $this->createIndex('{{%idx-vmuseum_reviews-vmuseum_id}}', '{{%vmuseum_reviews}}', 'vmuseum_id');
        $this->addForeignKey('{{%fk-vmuseum_reviews-vmuseum_id}}', '{{%vmuseum_reviews}}', 'vmuseum_id', '{{%vmuseum}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-vmuseum_reviews-user_id}}', '{{%vmuseum_reviews}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vmuseum_reviews}}');
    }
}

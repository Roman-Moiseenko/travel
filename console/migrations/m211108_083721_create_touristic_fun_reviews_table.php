<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%touristic_fun_reviews}}`.
 */
class m211108_083721_create_touristic_fun_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%touristic_fun_reviews}}', [
            'id' => $this->primaryKey(),
            'fun_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-touristic_fun_reviews-fun_id}}', '{{%touristic_fun_reviews}}', 'fun_id');
        $this->createIndex('{{%idx-touristic_fun_reviews-user_id}}', '{{%touristic_fun_reviews}}', 'user_id');

        $this->addForeignKey(
            '{{%fk-touristic_fun_reviews-fun_id}}',
            '{{%touristic_fun_reviews}}',
            'fun_id',
            '{{%touristic_fun}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-touristic_fun_reviews-user_id}}',
            '{{%touristic_fun_reviews}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%touristic_fun_reviews}}');
    }
}

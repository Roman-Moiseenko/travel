<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops}}`.
 */
class m210404_133233_create_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%shops}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'legal_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'type_id' => $this->integer(),
            'name' => $this->string(),
            'name_en' => $this->string(),
            'description' => $this->text(),
            'description_en' => $this->text(),

            'rating' => $this->decimal(3, 2),
            'status' => $this->integer(),
            'meta_json' => 'JSON',
        ], $tableOptions);

        $this->createIndex('{{%idx-shops-user_id}}', '{{%shops}}', 'user_id');
        $this->createIndex('{{%idx-shops-legal_id}}', '{{%shops}}', 'legal_id');
        $this->createIndex('{{%idx-shops-type_id}}', '{{%shops}}', 'type_id');

        $this->addForeignKey('{{%fk-shops-user_id}}', '{{%shops}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shops-legal_id}}', '{{%shops}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shops-type_id}}', '{{%shops}}', 'type_id', '{{%shops_type}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%touristic_fun}}`.
 */
class m211108_071023_create_touristic_fun_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%touristic_fun}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'title' => $this->string(),
            'slug' => $this->string()->unique(),
            'description' => $this->text(),
            'content' => 'MEDIUMTEXT',

            'main_photo_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'rating' => $this->decimal(5, 2),
            'featured_at' => $this->integer(),

            'contact_phone' => $this->string(),
            'contact_url' => $this->string(),
            'contact_email' => $this->string(),
            'address_address' => $this->string(),
            'address_latitude' => $this->string(),
            'address_longitude' => $this->string(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createIndex('{{%idx-touristic_fun-category_id}}', '{{%touristic_fun}}', 'category_id');
        $this->addForeignKey(
            '{{%idx-touristic_fun-category_id}}',
            '{{%touristic_fun}}',
            'category_id',
            'touristic_fun_category',
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
        $this->dropTable('{{%touristic_fun}}');
    }
}

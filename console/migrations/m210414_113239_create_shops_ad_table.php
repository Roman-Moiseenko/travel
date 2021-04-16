<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_ad}}`.
 */
class m210414_113239_create_shops_ad_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%shops_ad}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'legal_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'public_at' => $this->integer(),
            'type_id' => $this->integer(),
            'name' => $this->string(),
            'name_en' => $this->string(),
            'description' => $this->text(),
            'description_en' => $this->text(),

            'rating' => $this->decimal(3, 2),
            'status' => $this->integer(),
            'meta_json' => 'JSON',
            'main_photo_id' => $this->integer(),
            'slug' => $this->string()->unique(),
            'views' => $this->integer()->defaultValue(0),

        ], $tableOptions);

        $this->createIndex('{{%idx-shops_ad-user_id}}', '{{%shops_ad}}', 'user_id');
        $this->createIndex('{{%idx-shops_ad-legal_id}}', '{{%shops_ad}}', 'legal_id');
        $this->createIndex('{{%idx-shops_ad-type_id}}', '{{%shops_ad}}', 'type_id');

        $this->addForeignKey('{{%fk-shops_ad-user_id}}', '{{%shops_ad}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shops_ad-legal_id}}', '{{%shops_ad}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shops_ad-type_id}}', '{{%shops_ad}}', 'type_id', '{{%shops_type}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_ad}}');
    }
}

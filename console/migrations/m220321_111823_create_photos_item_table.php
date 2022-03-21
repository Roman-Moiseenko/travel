<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photos_item}}`.
 */
class m220321_111823_create_photos_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photos_page_items}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'photo' => $this->string(),
            'name' => $this->string(),
            'description' => $this->text(),
            'sort' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-photos_page_items-page_id}}', '{{%photos_page_items}}', 'page_id');

        $this->addForeignKey(
            '{{%fk-photos_page_items-page_id}}',
            '{{%photos_page_items}}',
            'page_id',
            '{{%photos_page}}',
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
        $this->dropTable('{{%photos_page_items}}');
    }
}

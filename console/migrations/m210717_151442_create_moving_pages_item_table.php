<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moving_pages_item}}`.
 */
class m210717_151442_create_moving_pages_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%moving_pages_item}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'sort' => $this->integer(),
            'main_photo_id' => $this->integer(),
            'title' => $this->string(),
            'text' => $this->text(),
            'rating' => $this->decimal(5, 2),

            'address_address' => $this->string(),
            'address_latitude' => $this->string(),
            'address_longitude' => $this->string(),
        ]);

        $this->createIndex('{{%idx-moving_pages_item-page_id}}', '{{%moving_pages_item}}', 'page_id');
        $this->addForeignKey(
            '{{%idx-moving_pages_item-page_id}}',
            '{{%moving_pages_item}}',
            'page_id',
            '{{%moving_pages}}',
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
        $this->dropTable('{{%moving_pages_item}}');
    }
}

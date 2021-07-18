<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moving_pages_item_photo}}`.
 */
class m210717_151452_create_moving_pages_item_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%moving_pages_item_photos}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-moving_pages_item_photos-activity_id}}', '{{%moving_pages_item_photos}}', 'item_id');
        $this->addForeignKey(
            '{{%fk-moving_pages_item_photos-item_id}}',
            '{{%moving_pages_item_photos}}',
            'item_id',
            '{{%moving_pages_item}}',
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
        $this->dropTable('{{%moving_pages_item_photos}}');
    }
}

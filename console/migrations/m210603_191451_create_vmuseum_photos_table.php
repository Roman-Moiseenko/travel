<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vmuseum_photos}}`.
 */
class m210603_191451_create_vmuseum_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vmuseum_photos}}', [
            'id' => $this->primaryKey(),
            'vmuseum_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-vmuseum_photos-vmuseum_id}}', '{{%vmuseum_photos}}', 'vmuseum_id');
        $this->addForeignKey(
            '{{%fk-vmuseum_photos-vmuseum_id}}',
            '{{%vmuseum_photos}}',
            'vmuseum_id',
            '{{%vmuseum}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vmuseum_photos}}');
    }
}

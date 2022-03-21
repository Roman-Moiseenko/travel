<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photos_tag_assignment}}`.
 */
class m220321_110044_create_photos_tag_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photos_tag_assignment}}', [
            'page_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-photos_tag_assignment}}', '{{%photos_tag_assignment}}', ['page_id', 'tag_id']);

        $this->createIndex('{{%idx-photos_tag_assignment-page_id}}', '{{%photos_tag_assignment}}', 'page_id');
        $this->createIndex('{{%idx-photos_tag_assignment-tag_id}}', '{{%photos_tag_assignment}}', 'tag_id');

        $this->addForeignKey(
            '{{%fk-photos_tag_assignment-page_id}}',
            '{{%photos_tag_assignment}}',
            'page_id',
            '{{%photos_page}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-photos_tag_assignment-tag_id}}',
            '{{%photos_tag_assignment}}',
            'tag_id',
            '{{%photos_tags}}',
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
        $this->dropTable('{{%photos_tag_assignment}}');
    }
}

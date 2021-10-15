<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%realtor_landowners_photos}}`.
 */
class m211014_204725_create_realtor_landowners_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%realtor_landowners_photos}}', [
            'id' => $this->primaryKey(),
            'landowners_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-realtor_landowners_photos-landowners_id}}', '{{%realtor_landowners_photos}}', 'landowners_id');
        $this->addForeignKey(
            '{{%fk-realtor_landowners_photos-landowners_id}}',
            '{{%realtor_landowners_photos}}',
            'landowners_id',
            '{{%realtor_landowners}}',
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
        $this->dropTable('{{%realtor_landowners_photos}}');
    }
}

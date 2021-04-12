<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_maps_point}}`.
 */
class m210411_212614_create_blog_maps_point_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_maps_point}}', [
            'id' => $this->primaryKey(),
            'map_id' => $this->integer()->notNull(),
            'address' => $this->string(),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
            'caption' => $this->string(),
            'photo' => $this->string(),
            'link' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-blog_maps_point-map_id}}', '{{%blog_maps_point}}', 'map_id');
        $this->addForeignKey(
            '{{%fk-blog_maps_point-map_id}}',
            '{{%blog_maps_point}}',
            'map_id',
            '{{%blog_maps}}',
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
        $this->dropTable('{{%blog_maps_point}}');
    }
}

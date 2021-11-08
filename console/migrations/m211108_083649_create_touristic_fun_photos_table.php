<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%touristic_fun_photos}}`.
 */
class m211108_083649_create_touristic_fun_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%touristic_fun_photos}}', [
            'id' => $this->primaryKey(),
            'fun_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-touristic_fun_photos-fun_id}}', '{{%touristic_fun_photos}}', 'fun_id');
        $this->addForeignKey(
            '{{%fk-touristic_fun_photos-fun_id}}',
            '{{%touristic_fun_photos}}',
            'fun_id',
            '{{%touristic_fun}}',
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
        $this->dropTable('{{%touristic_fun_photos}}');
    }
}

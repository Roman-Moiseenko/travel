<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs_photos}}`.
 */
class m201201_095952_create_booking_funs_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_funs_photos}}', [
            'id' => $this->primaryKey(),
            'fun_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_funs_photos-fun_id}}', '{{%booking_funs_photos}}', 'fun_id');
        $this->addForeignKey('{{%fk-booking_funs_photos-fun_id}}', '{{%booking_funs_photos}}', 'fun_id', '{{%booking_funs}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs_photos}}');
    }
}

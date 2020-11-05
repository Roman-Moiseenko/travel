<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mailing}}`.
 */
class m201103_200511_create_mailing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mailing}}', [
            'id' => $this->primaryKey(),
            'theme' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'send_at' => $this->integer(),
            'subject' =>$this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mailing}}');
    }
}

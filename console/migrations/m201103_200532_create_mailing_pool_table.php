<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mailing_pool}}`.
 */
class m201103_200532_create_mailing_pool_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mailing_pool}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'pool_at' => $this->integer(),
            'caption' => $this->string(),
            'promotion' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mailing_pool}}');
    }
}

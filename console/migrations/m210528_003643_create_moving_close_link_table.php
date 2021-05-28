<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moving_close_link}}`.
 */
class m210528_003643_create_moving_close_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%moving_close_link}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string()->notNull()->unique(),
            'url' => $this->string()->notNull(),
            'anchor' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%moving_close_link}}');
    }
}

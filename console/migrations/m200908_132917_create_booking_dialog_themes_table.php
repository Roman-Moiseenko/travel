<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_dialog_themes}}`.
 */
class m200908_132917_create_booking_dialog_themes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_dialog_themes}}', [
            'id' => $this->primaryKey(),
            'caption' => $this->string(),
            'type_dialog' => $this->integer(),
        ]);
        $this->insert('{{%booking_dialog_themes}}', [
            'id' => 1,
            'caption' => 'Жалоба на отзыв',
            'type_dialog' => 2
        ]);

        $this->insert('{{%booking_dialog_themes}}', [
            'id' => 2,
            'caption' => 'Жалоба на провайдера',
            'type_dialog' => 3
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_dialog_themes}}');
    }
}

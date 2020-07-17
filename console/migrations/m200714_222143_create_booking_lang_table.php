<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_lang}}`.
 */
class m200714_222143_create_booking_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_lang}}', [
            'ru' => $this->text(),
            'en' => $this->text(),
            'pl' => $this->text(),
            'de' => $this->text(),
            'fr' => $this->text(),
            'lv' => $this->text(),
            'lt' => $this->text(),
        ]);
        $this->createIndex('{{%idx-booking_lang-ru}}', '{{%booking_lang}}', 'ru');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_lang}}');
    }
}

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
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_lang}}', [
            'ru' => $this->string(),
            'en' => $this->string(),
            'pl' => $this->string(),
            'de' => $this->string(),
            'fr' => $this->string(),
            'lv' => $this->string(),
            'lt' => $this->string(),
        ], $tableOptions);
        $this->addPrimaryKey('{{%pk-booking_lang}}', '{{%booking_lang}}', ['ru']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_lang}}');
    }
}

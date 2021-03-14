<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services_photo_resize}}`.
 */
class m210314_184359_create_services_photo_resize_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%services_photo_resize}}', [
            'id' => $this->primaryKey(),
            'file' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%services_photo_resize}}');
    }
}

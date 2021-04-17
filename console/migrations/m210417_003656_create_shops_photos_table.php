<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_photos}}`.
 */
class m210417_003656_create_shops_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_photos}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-shops_photos-shop_id}}', '{{%shops_photos}}', 'shop_id');
        $this->addForeignKey(
            '{{%fk-shops_photos-shop_id}}',
            '{{%shops_photos}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_photos}}');
    }
}

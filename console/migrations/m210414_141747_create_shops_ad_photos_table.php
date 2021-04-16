<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_ad_photos}}`.
 */
class m210414_141747_create_shops_ad_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_ad_photos}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-shops_ad_photos-shop_id}}', '{{%shops_ad_photos}}', 'shop_id');
        $this->addForeignKey(
            '{{%fk-shops_ad_photos-shop_id}}',
            '{{%shops_ad_photos}}',
            'shop_id',
            '{{%shops_ad}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_ad_photos}}');
    }
}

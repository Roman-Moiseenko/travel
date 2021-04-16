<?php

use yii\db\Migration;

/**
 * Class m210414_142055_add_shops_ad_main_photo_index
 */
class m210414_142055_add_shops_ad_main_photo_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-shops_ad-main_photo_id}}', '{{%shops_ad}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-shops_ad-main_photo_id}}',
            '{{%shops_ad}}',
            'main_photo_id',
            '{{%shops_ad_photos}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210414_142055_add_shops_ad_main_photo_index cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210414_142055_add_shops_ad_main_photo_index cannot be reverted.\n";

        return false;
    }
    */
}

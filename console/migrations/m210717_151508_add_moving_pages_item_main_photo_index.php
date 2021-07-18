<?php

use yii\db\Migration;

/**
 * Class m210717_151508_add_moving_pages_item_main_photo_index
 */
class m210717_151508_add_moving_pages_item_main_photo_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-moving_pages_item-main_photo_id}}', '{{%moving_pages_item}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-moving_pages_item-main_photo_id}}',
            '{{%moving_pages_item}}',
            'main_photo_id',
            '{{%moving_pages_item_photos}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210717_151508_add_moving_pages_item_main_photo_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210717_151508_add_moving_pages_item_main_photo_index cannot be reverted.\n";

        return false;
    }
    */
}

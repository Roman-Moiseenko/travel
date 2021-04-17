<?php

use yii\db\Migration;

/**
 * Class m210417_003734_add_shops_main_photo_index
 */
class m210417_003734_add_shops_main_photo_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-shops-main_photo_id}}', '{{%shops}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-shops-main_photo_id}}',
            '{{%shops}}',
            'main_photo_id',
            '{{%shops_photos}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210417_003734_add_shops_main_photo_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210417_003734_add_shops_main_photo_index cannot be reverted.\n";

        return false;
    }
    */
}

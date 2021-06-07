<?php

use yii\db\Migration;

/**
 * Class m210603_191807_add_vmuseum_main_photo_index
 */
class m210603_191807_add_vmuseum_main_photo_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-vmuseum-main_photo_id}}', '{{%vmuseum}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-vmuseum-main_photo_id}}',
            '{{%vmuseum}}',
            'main_photo_id',
            '{{%vmuseum_photos}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210603_191807_add_vmuseum_main_photo_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210603_191807_add_vmuseum_main_photo_index cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m211014_204803_add_realtor_landowners_main_photo_index
 */
class m211014_204803_add_realtor_landowners_main_photo_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-realtor_landowners-main_photo_id}}', '{{%realtor_landowners}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-realtor_landowners-main_photo_id}}',
            '{{%realtor_landowners}}',
            'main_photo_id',
            '{{%realtor_landowners_photos}}',
            'id',
            'SET NULL',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211014_204803_add_realtor_landowners_main_photo_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211014_204803_add_realtor_landowners_main_photo_index cannot be reverted.\n";

        return false;
    }
    */
}

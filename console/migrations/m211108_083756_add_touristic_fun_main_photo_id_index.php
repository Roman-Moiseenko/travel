<?php

use yii\db\Migration;

/**
 * Class m211108_083756_add_touristic_fun_main_photo_id_index
 */
class m211108_083756_add_touristic_fun_main_photo_id_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-touristic_fun-main_photo_id}}', '{{%touristic_fun}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-touristic_fun-main_photo_id}}',
            '{{%touristic_fun}}',
            'main_photo_id',
            '{{%touristic_fun_photos}}',
            'id',
            'SET NULL',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211108_083756_add_touristic_fun_main_photo_id_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211108_083756_add_touristic_fun_main_photo_id_index cannot be reverted.\n";

        return false;
    }
    */
}

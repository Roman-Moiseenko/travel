<?php

use yii\db\Migration;

/**
 * Class m210418_192637_update_main_photo_id_index
 */
class m210418_192637_update_main_photo_id_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Tour
        $this->createIndex('{{%idx-booking_tours-main_photo_id}}', '{{%booking_tours}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-booking_tours-main_photo_id}}',
            '{{%booking_tours}}',
            'main_photo_id',
            '{{%booking_tours_photos}}',
            'id',
            'SET NULL',
            'RESTRICT');

        //Funs
        $this->createIndex('{{%idx-booking_funs-main_photo_id}}', '{{%booking_funs}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-booking_funs-main_photo_id}}',
            '{{%booking_funs}}',
            'main_photo_id',
            '{{%booking_funs_photos}}',
            'id',
            'SET NULL',
            'RESTRICT');

        //Cars
        $this->createIndex('{{%idx-booking_cars-main_photo_id}}', '{{%booking_cars}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-booking_cars-main_photo_id}}',
            '{{%booking_cars}}',
            'main_photo_id',
            '{{%booking_cars_photos}}',
            'id',
            'SET NULL',
            'RESTRICT');

        //Shops
        $this->dropForeignKey('{{%fk-shops-main_photo_id}}', '{{%shops}}');
        $this->addForeignKey(
            '{{%fk-shops-main_photo_id}}',
            '{{%shops}}',
            'main_photo_id',
            '{{%shops_photos}}',
            'id',
            'SET NULL',
            'RESTRICT');

        //Products
        $this->dropForeignKey('{{%fk-shops_product-main_photo_id}}', '{{%shops_product}}');
        $this->addForeignKey(
            '{{%fk-shops_product-main_photo_id}}',
            '{{%shops_product}}',
            'main_photo_id',
            '{{%shops_product_photos}}',
            'id',
            'SET NULL',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210418_192637_update_main_photo_id_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210418_192637_update_main_photo_id_index cannot be reverted.\n";

        return false;
    }
    */
}

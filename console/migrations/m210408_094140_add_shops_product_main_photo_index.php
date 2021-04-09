<?php

use yii\db\Migration;

/**
 * Class m210408_094140_add_shops_product_main_photo_index
 */
class m210408_094140_add_shops_product_main_photo_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-shops_product-main_photo_id}}', '{{%shops_product}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-shops_product-main_photo_id}}',
            '{{%shops_product}}',
            'main_photo_id',
            '{{%shops_product_photos}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210408_094140_add_shops_product_main_photo_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210408_094140_add_shops_product_main_photo_index cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m210429_080123_add_shops_product_category_photo_field
 */
class m210429_080123_add_shops_product_category_photo_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_product_category}}', 'photo', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210429_080123_add_shops_product_category_photo_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210429_080123_add_shops_product_category_photo_field cannot be reverted.\n";

        return false;
    }
    */
}

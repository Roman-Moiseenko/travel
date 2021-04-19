<?php

use yii\db\Migration;

/**
 * Class m210418_004247_add_shops_product_rating_field
 */
class m210418_004247_add_shops_product_rating_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_product}}', 'rating', $this->decimal(3, 2)->defaultValue(0));
        $this->update('{{%shops_product}}', ['rating' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210418_004247_add_shops_product_rating_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210418_004247_add_shops_product_rating_field cannot be reverted.\n";

        return false;
    }
    */
}

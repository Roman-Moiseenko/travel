<?php

use yii\db\Migration;

/**
 * Class m210407_171852_add_shops_product_category_root_row
 */
class m210407_171852_add_shops_product_category_root_row extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%shops_product_category}}', [
            'id' => 1,
            'name' => '',
            'slug' => 'root',
            'title' => null,
            'description' => null,
            'meta_json' => '{}',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210407_171852_add_shops_product_category_root_row cannot be reverted.\n";

        return false;
    }
    */
}

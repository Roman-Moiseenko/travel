<?php

use yii\db\Migration;

/**
 * Class m210718_185526_add_moving_pages_item_post_id_field
 */
class m210718_185526_add_moving_pages_item_post_id_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%moving_pages_item}}', 'post_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%moving_pages_item}}', 'post_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210718_185526_add_moving_pages_item_post_id_field cannot be reverted.\n";

        return false;
    }
    */
}

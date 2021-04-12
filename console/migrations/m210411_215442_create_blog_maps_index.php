<?php

use yii\db\Migration;

/**
 * Class m210411_215442_create_blog_maps_index
 */
class m210411_215442_create_blog_maps_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-blog_maps-slug}}', '{{%blog_maps}}', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210411_215442_create_blog_maps_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210411_215442_create_blog_maps_index cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m201020_152539_add_blog_posts_content_en_field
 */
class m201020_152539_add_blog_posts_content_en_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_posts}}', 'content_en', 'MEDIUMTEXT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_posts}}', 'content_en');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201020_152539_add_blog_posts_content_en_field cannot be reverted.\n";

        return false;
    }
    */
}

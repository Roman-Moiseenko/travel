<?php

use yii\db\Migration;

/**
 * Class m201020_151103_add_blog_posts_en_fields
 */
class m201020_151103_add_blog_posts_en_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_posts}}', 'title_en', $this->string());
        $this->addColumn('{{%blog_posts}}', 'description_en', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_posts}}', 'title_en');
        $this->dropColumn('{{%blog_posts}}', 'description_en');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201020_151103_add_blog_posts_en_fields cannot be reverted.\n";

        return false;
    }
    */
}

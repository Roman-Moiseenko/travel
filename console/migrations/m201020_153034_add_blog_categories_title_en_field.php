<?php

use yii\db\Migration;

/**
 * Class m201020_153034_add_blog_categories_title_en_field
 */
class m201020_153034_add_blog_categories_title_en_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_categories}}', 'title_en', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_categories}}', 'title_en');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201020_153034_add_blog_categories_title_en_field cannot be reverted.\n";

        return false;
    }
    */
}

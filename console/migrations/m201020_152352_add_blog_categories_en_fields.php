<?php

use yii\db\Migration;

/**
 * Class m201020_152352_add_blog_categories_en_fields
 */
class m201020_152352_add_blog_categories_en_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_categories}}', 'name_en', $this->string());
        $this->addColumn('{{%blog_categories}}', 'description_en', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_categories}}', 'name_en');
        $this->dropColumn('{{%blog_categories}}', 'description_en');;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201020_152352_add_blog_categories_en_fields cannot be reverted.\n";

        return false;
    }
    */
}

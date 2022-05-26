<?php

use yii\db\Migration;

/**
 * Class m220526_074412_add_post_updated_at_field
 */
class m220526_074412_add_post_updated_at_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_posts}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220526_074412_add_post_updated_at_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220526_074412_add_post_updated_at_field cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m201213_223919_add_forum_posts_category_index
 */
class m201213_223919_add_forum_posts_category_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-forum_posts-category_id}}', '{{%forum_posts}}', 'category_id');
        $this->addForeignKey('{{%fk-forum_posts-category_id}}', '{{%forum_posts}}', 'category_id', '{{%forum_categories}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-forum_posts-category_id}}', '{{%forum_posts}}');
        $this->dropIndex('{{%idx-forum_posts-category_id}}', '{{%forum_posts}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201213_223919_add_forum_posts_category_index cannot be reverted.\n";

        return false;
    }
    */
}

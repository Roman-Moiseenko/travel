<?php

use yii\db\Migration;

/**
 * Class m210721_112829_add_moving_pages_description_field
 */
class m210721_112829_add_moving_pages_description_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%moving_pages}}', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%moving_pages}}', 'description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210721_112829_add_moving_pages_description_field cannot be reverted.\n";

        return false;
    }
    */
}

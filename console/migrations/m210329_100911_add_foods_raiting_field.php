<?php

use yii\db\Migration;

/**
 * Class m210329_100911_add_foods_raiting_field
 */
class m210329_100911_add_foods_raiting_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%foods}}', 'rating', $this->decimal(3,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%foods}}', 'rating');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210329_100911_add_foods_raiting_field cannot be reverted.\n";

        return false;
    }
    */
}

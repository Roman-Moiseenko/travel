<?php

use yii\db\Migration;

/**
 * Class m210716_204821_add_moving_pages_icon_field
 */
class m210716_204821_add_moving_pages_icon_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%moving_pages}}', 'icon', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210716_204821_add_moving_pages_icon_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210716_204821_add_moving_pages_icon_field cannot be reverted.\n";

        return false;
    }
    */
}

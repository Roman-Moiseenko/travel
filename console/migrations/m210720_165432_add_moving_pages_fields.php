<?php

use yii\db\Migration;

/**
 * Class m210720_165432_add_moving_pages_fields
 */
class m210720_165432_add_moving_pages_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%moving_pages}}', 'name', $this->string());
        $this->addColumn('{{%moving_pages}}', 'photo', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%moving_pages}}', 'name');
        $this->dropColumn('{{%moving_pages}}', 'photo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210720_165432_add_moving_pages_fields cannot be reverted.\n";

        return false;
    }
    */
}

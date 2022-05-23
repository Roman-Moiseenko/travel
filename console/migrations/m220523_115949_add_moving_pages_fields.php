<?php

use yii\db\Migration;

/**
 * Class m220523_115949_add_moving_pages_fields
 */
class m220523_115949_add_moving_pages_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%moving_pages}}', 'created_at', $this->integer()->notNull());
        $this->update('{{%moving_pages}}', ['created_at' => time()]);

        $this->addColumn('{{%moving_pages}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220523_115949_add_moving_pages_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220523_115949_add_moving_pages_fields cannot be reverted.\n";

        return false;
    }
    */
}

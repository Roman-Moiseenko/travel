<?php

use yii\db\Migration;

/**
 * Class m211111_075450_add_touristic_fun_sort_field
 */
class m211111_075450_add_touristic_fun_sort_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%touristic_fun}}', 'sort', $this->integer());
        $this->update('{{%touristic_fun}}', ['sort' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211111_075450_add_touristic_fun_sort_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211111_075450_add_touristic_fun_sort_field cannot be reverted.\n";

        return false;
    }
    */
}

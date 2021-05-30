<?php

use yii\db\Migration;

/**
 * Class m210530_071528_add_office_price_list_name_field
 */
class m210530_071528_add_office_price_list_name_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%office_price_list}}', 'name', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210530_071528_add_office_price_list_name_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210530_071528_add_office_price_list_name_field cannot be reverted.\n";

        return false;
    }
    */
}

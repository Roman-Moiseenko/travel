<?php

use yii\db\Migration;

/**
 * Class m210218_210847_edit_booking_stays_rules_fields
 */
class m210218_210847_edit_booking_stays_rules_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%booking_stays_rules}}', 'children_json', 'limit_json');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%booking_stays_rules}}', 'limit_json', 'children_json');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210218_210847_edit_booking_stays_rules_fields cannot be reverted.\n";

        return false;
    }
    */
}

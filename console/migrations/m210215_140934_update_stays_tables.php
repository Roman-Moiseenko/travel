<?php

use yii\db\Migration;

/**
 * Class m210215_140934_update_stays_tables
 */
class m210215_140934_update_stays_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%booking_stays_type}}', 'mono');

        $this->addColumn('{{%booking_stays_comfort_category}}', 'image', $this->string());

        $this->renameTable('{{%booking_stays_assign_comfort}}', '{{%booking_stays_comfort_assign}}');
        $this->addColumn('{{%booking_stays_comfort_assign}}', 'photo', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210215_140934_update_stays_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210215_140934_update_stays_tables cannot be reverted.\n";

        return false;
    }
    */
}

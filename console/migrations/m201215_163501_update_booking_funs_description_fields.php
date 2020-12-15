<?php

use yii\db\Migration;

/**
 * Class m201215_163501_update_booking_funs_description_fields
 */
class m201215_163501_update_booking_funs_description_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%booking_funs}}', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201215_163501_update_booking_funs_description_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201215_163501_update_booking_funs_description_fields cannot be reverted.\n";

        return false;
    }
    */
}

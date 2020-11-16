<?php

use yii\db\Migration;

/**
 * Class m201105_201754_alter_booking_tours_extra_field
 */
class m201105_201754_alter_booking_tours_extra_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%booking_tours_extra}}', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%booking_tours_extra}}', 'description', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201105_201754_alter_booking_tours_extra_field cannot be reverted.\n";

        return false;
    }
    */
}

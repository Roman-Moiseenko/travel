<?php

use yii\db\Migration;

/**
 * Class m201020_194245_update_booking_tours_fields
 */
class m201020_194245_update_booking_tours_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%booking_tours}}' , 'name', $this->string()->unique());
        $this->alterColumn('{{%booking_tours}}' , 'slug', $this->string()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%booking_tours}}' , 'name', $this->string());
        $this->alterColumn('{{%booking_tours}}' , 'slug', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201020_194245_update_booking_tours_fields cannot be reverted.\n";

        return false;
    }
    */
}

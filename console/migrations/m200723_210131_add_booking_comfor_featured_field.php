<?php

use yii\db\Migration;

/**
 * Class m200723_210131_add_booking_comfor_featured_field
 */
class m200723_210131_add_booking_comfor_featured_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_comfort}}', 'featured', $this->boolean());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{%booking_stays_comfort}}', 'featured');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200723_210131_add_booking_comfor_featured_field cannot be reverted.\n";

        return false;
    }
    */
}

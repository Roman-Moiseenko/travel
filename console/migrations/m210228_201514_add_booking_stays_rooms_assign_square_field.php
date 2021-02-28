<?php

use yii\db\Migration;

/**
 * Class m210228_201514_add_booking_stays_rooms_assign_square_field
 */
class m210228_201514_add_booking_stays_rooms_assign_square_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_rooms_assign}}', 'square', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays_rooms_assign}}', 'square');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210228_201514_add_booking_stays_rooms_assign_square_field cannot be reverted.\n";

        return false;
    }
    */
}

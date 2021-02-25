<?php

use yii\db\Migration;

/**
 * Class m210223_203056_edit_booking_stays_nearby_category_group_field
 */
class m210223_203056_edit_booking_stays_nearby_category_group_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%booking_stays_nearby_category}}', ['group' => 1]);
        $this->alterColumn('{{%booking_stays_nearby_category}}', 'group', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%booking_stays_nearby_category}}', 'group', $this->string());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210223_203056_edit_booking_stays_nearby_category_group_field cannot be reverted.\n";

        return false;
    }
    */
}

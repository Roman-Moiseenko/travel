<?php

use yii\db\Migration;

/**
 * Class m200903_162114_add_booking_discount_user_id_field
 */
class m200903_162114_add_booking_discount_user_id_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_discount}}', 'user_id', $this->integer());
        $this->createIndex('{{%idx-booking_discount-discount_id}}', '{{%booking_discount}}', 'user_id');
        $this->addForeignKey('{{%fk-booking_discount-discount_id}}', '{{%booking_discount}}', 'user_id', '{{%admin_users}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_discount}}', 'user_id');
        $this->dropIndex('{{%idx-booking_discount-discount_id}}', '{{%booking_discount}}');
        $this->dropForeignKey('{{%fk-booking_discount-discount_id}}', '{{%booking_discount}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_162114_add_booking_discount_user_id_field cannot be reverted.\n";

        return false;
    }
    */
}

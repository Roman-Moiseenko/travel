<?php

use yii\db\Migration;

/**
 * Class m201209_121935_update_type_id_fields
 */
class m201209_121935_update_type_id_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%booking_funs}}', 'type_id', $this->integer()->null());
        $this->dropForeignKey('{{%fk-booking_funs-type_id}}', '{{%booking_funs}}');
        $this->addForeignKey('{{%fk-booking_funs-type_id}}', '{{%booking_funs}}', 'type_id', '{{%booking_funs_type}}', 'id', 'SET NULL', 'RESTRICT');

        $this->dropForeignKey('{{%fk-booking_funs-legal_id}}', '{{%booking_funs}}');
        $this->addForeignKey('{{%fk-booking_funs-legal_id}}', '{{%booking_funs}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'SET NULL', 'RESTRICT');

        $this->alterColumn('{{%booking_cars}}', 'type_id', $this->integer()->null());
        $this->dropForeignKey('{{%fk-booking_cars-type_id}}', '{{%booking_cars}}');
        $this->addForeignKey('{{%fk-booking_cars-type_id}}', '{{%booking_cars}}', 'type_id', '{{%booking_cars_type}}', 'id', 'SET NULL', 'RESTRICT');

        $this->alterColumn('{{%booking_tours}}', 'type_id', $this->integer()->null());
        $this->dropForeignKey('{{%fk-booking_tours-type_id}}', '{{%booking_tours}}');
        $this->addForeignKey('{{%fk-booking_tours-type_id}}', '{{%booking_tours}}', 'type_id', '{{%booking_tours_type}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201209_121935_update_type_id_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201209_121935_update_type_id_fields cannot be reverted.\n";

        return false;
    }
    */
}

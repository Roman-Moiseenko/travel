<?php

use yii\db\Migration;

/**
 * Class m200722_235941_create_booking_stays_comfort_tables
 */
class m200722_235941_create_booking_stays_comfort_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays_comfort_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
            ]);

        $this->createTable('{{%booking_stays_comfort}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
            'editpay' => $this->boolean(),
        ]);
        $this->createIndex('{{%idx-booking_stays_comfort-category_id}}', '{{%booking_stays_comfort}}', 'category_id');
        $this->addForeignKey('{{%fk-booking_stays_comfort-category_id}}', '{{%booking_stays_comfort}}', 'category_id',
            '{{%booking_stays_comfort_category}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%booking_stays_assign_comfort}}', [
            'stays_id' => $this->integer(),
            'comfort_id' => $this->integer(),
            'pay' => $this->boolean()
        ]);

        $this->addPrimaryKey('{{%pk-booking_stays_comfort}}', '{{%booking_stays_comfort}}', ['stays_id', 'comfort_id']);

        $this->createIndex('{{%idx-booking_stays_comfort-product_id}}', '{{%booking_stays_comfort}}', 'stays_id');
        $this->createIndex('{{%idx-booking_stays_comfort-characteristic_id}}', '{{%booking_stays_comfort}}', 'comfort_id');

        $this->addForeignKey('{{%fk-booking_stays_comfort-product_id}}', '{{%booking_stays_comfort}}', 'stays_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stays_comfort-characteristic_id}}', '{{%booking_stays_comfort}}', 'comfort_id', '{{%booking_stays_comfort}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_comfort_category}}');
        $this->dropTable('{{%booking_stays_comfort}}');
        $this->dropTable('{{%booking_stays_assign_comfort}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200722_235941_create_booking_stays_comfort_tables cannot be reverted.\n";

        return false;
    }
    */
}

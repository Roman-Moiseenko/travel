<?php

use yii\db\Migration;

/**
 * Class m201101_150606_add_booking_tours_public_at_field
 */
class m201101_150606_add_booking_tours_public_at_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours}}', 'public_at', $this->integer());
        $this->update('{{%booking_tours}}', ['public_at' => time()]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours}}', 'public_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201101_150606_add_booking_tours_public_at_field cannot be reverted.\n";

        return false;
    }
    */
}

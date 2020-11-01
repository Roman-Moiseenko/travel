<?php

use yii\db\Migration;

/**
 * Class m201101_112524_add_booking_tours_views_field
 */
class m201101_112524_add_booking_tours_views_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours}}', 'views', $this->integer()->defaultValue(0));
        $this->update('{{%booking_tours}}', ['views' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours}}', 'views');
    }

}

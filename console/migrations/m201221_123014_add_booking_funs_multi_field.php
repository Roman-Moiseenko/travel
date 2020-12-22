<?php

use yii\db\Migration;

/**
 * Class m201221_123014_add_booking_funs_multi_field
 */
class m201221_123014_add_booking_funs_multi_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_funs}}', 'multi', $this->boolean()->defaultValue(false));
        $this->update('{{%booking_funs}}', ['multi' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_funs}}', 'multi');
    }

}

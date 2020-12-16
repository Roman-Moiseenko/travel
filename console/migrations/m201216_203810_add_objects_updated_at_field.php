<?php

use yii\db\Migration;

/**
 * Class m201216_203810_add_objects_updated_at_field
 */
class m201216_203810_add_objects_updated_at_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours}}', 'updated_at', $this->integer());
        $this->addColumn('{{%booking_cars}}', 'updated_at', $this->integer());
        $this->addColumn('{{%booking_funs}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours}}', 'updated_at');
        $this->dropColumn('{{%booking_cars}}', 'updated_at');
        $this->dropColumn('{{%booking_funs}}', 'updated_at');
    }
}

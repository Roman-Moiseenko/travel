<?php

use yii\db\Migration;

/**
 * Class m201220_204107_add_booking_funs_type_multi_field
 */
class m201220_204107_add_booking_funs_type_multi_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_funs_type}}', 'multi', $this->boolean()->defaultValue(false));
        $this->update('{{%booking_funs_type}}', ['multi' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_funs_type}}', 'multi');
    }

}

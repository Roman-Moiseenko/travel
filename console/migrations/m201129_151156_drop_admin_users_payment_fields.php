<?php

use booking\entities\admin\User;
use yii\db\Migration;

/**
 * Class m201129_151156_drop_admin_users_payment_fields
 */
class m201129_151156_drop_admin_users_payment_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%admin_users}}', 'payment_at');
        $this->dropColumn('{{%admin_users}}', 'payment_level');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%admin_users}}', 'payment_at', $this->integer());
        $this->addColumn('{{%admin_users}}', 'payment_level', $this->integer()->defaultValue(0));
        $this->update('{{%admin_users}}',['payment_level' => 0]);
    }

}

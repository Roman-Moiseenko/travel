<?php

use booking\entities\admin\User;
use yii\db\Migration;

/**
 * Class m201029_162613_add_user_admin_payments_fields
 */
class m201029_162613_add_user_admin_payments_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%admin_users}}', 'payment_at', $this->integer());
        $this->addColumn('{{%admin_users}}', 'payment_level', $this->integer()->defaultValue(0));
        $this->update('{{%admin_users}}',['payment_level' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%admin_users}}', 'payment_at');
        $this->dropColumn('{{%admin_users}}', 'payment_level');
    }

}

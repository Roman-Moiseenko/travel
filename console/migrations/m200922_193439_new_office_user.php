<?php

use booking\entities\office\User;
use yii\db\Migration;

/**
 * Class m200922_193439_new_office_user
 */
class m200922_193439_new_office_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = User::create('super_admin', 'r.a.moiseenko@gmail.com', 'foolprof');
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200922_193439_new_office_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200922_193439_new_office_user cannot be reverted.\n";

        return false;
    }
    */
}

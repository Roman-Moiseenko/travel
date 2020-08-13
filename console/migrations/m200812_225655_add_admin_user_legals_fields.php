<?php

use yii\db\Migration;

/**
 * Class m200812_225655_add_admin_user_legals_fields
 */
class m200812_225655_add_admin_user_legals_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%admin_user_legals}}', 'photo', $this->string());
        $this->addColumn('{{%admin_user_legals}}', 'caption', $this->string());
        $this->addColumn('{{%admin_user_legals}}', 'description', $this->text());
        $this->addColumn('{{%admin_user_legals}}', 'adr_address', $this->string());
        $this->addColumn('{{%admin_user_legals}}', 'adr_latitude', $this->string());
        $this->addColumn('{{%admin_user_legals}}', 'adr_longitude', $this->string());
        $this->addColumn('{{%admin_user_legals}}', 'created_at', $this->integer());
        $this->addColumn('{{%admin_user_legals}}', 'office', $this->string());
        $this->addColumn('{{%admin_user_legals}}', 'noticePhone', $this->string());
        $this->addColumn('{{%admin_user_legals}}', 'noticeEmail', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{%admin_user_legals}}', 'photo');
        $this->dropColumn('{{%admin_user_legals}}', 'caption');
        $this->dropColumn('{{%admin_user_legals}}', 'description');
        $this->dropColumn('{{%admin_user_legals}}', 'adr_address');
        $this->dropColumn('{{%admin_user_legals}}', 'adr_latitude');
        $this->dropColumn('{{%admin_user_legals}}', 'adr_longitude');
        $this->dropColumn('{{%admin_user_legals}}', 'created_at');
        $this->dropColumn('{{%admin_user_legals}}', 'office');
        $this->dropColumn('{{%admin_user_legals}}', 'noticePhone');
        $this->dropColumn('{{%admin_user_legals}}', 'noticeEmail');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200812_225655_add_admin_user_legals_fields cannot be reverted.\n";

        return false;
    }
    */
}

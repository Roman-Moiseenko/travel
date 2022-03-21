<?php

use yii\db\Migration;

/**
 * Class m220317_142329_add_office_users_fields
 */
class m220317_142329_add_office_users_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%office_users}}', 'photo', $this->string());
        $this->addColumn('{{%office_users}}', 'home_page', $this->string());
        $this->addColumn('{{%office_users}}', 'description', $this->text());

        $this->addColumn('{{%office_users}}', 'person_surname', $this->string());
        $this->addColumn('{{%office_users}}', 'person_firstname', $this->string());
        $this->addColumn('{{%office_users}}', 'person_secondname', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220317_142329_add_office_users_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220317_142329_add_office_users_fields cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m211128_153217_add_land_anonymous_address_fields
 */
class m211128_153217_add_land_anonymous_address_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%land_anonymous}}', 'address_address', $this->string());
        $this->addColumn('{{%land_anonymous}}', 'address_latitude', $this->string());
        $this->addColumn('{{%land_anonymous}}', 'address_longitude', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211128_153217_add_land_anonymous_address_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211128_153217_add_land_anonymous_address_fields cannot be reverted.\n";

        return false;
    }
    */
}

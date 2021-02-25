<?php

use yii\db\Migration;

/**
 * Class m210219_080519_edit_booking_stays_fields
 */
class m210219_080519_edit_booking_stays_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays}}', 'updated_at', $this->integer());
        $this->addColumn('{{%booking_stays}}', 'name_en', $this->string());
        $this->addColumn('{{%booking_stays}}', 'description', $this->string());
        $this->addColumn('{{%booking_stays}}', 'description_en', $this->string());
        $this->addColumn('{{%booking_stays}}', 'cancellation', $this->integer());
        $this->addColumn('{{%booking_stays}}', 'check_booking', $this->integer());
        $this->addColumn('{{%booking_stays}}', 'quantity', $this->integer());
        $this->addColumn('{{%booking_stays}}', 'views', $this->integer());
        $this->addColumn('{{%booking_stays}}', 'public_at', $this->integer());
        $this->addColumn('{{%booking_stays}}', 'params_json', 'JSON NOT NULL');
        $this->addColumn('{{%booking_stays}}', 'slug', $this->string()->unique());
        $this->addColumn('{{%booking_stays}}', 'cost', $this->integer());

        $this->dropColumn('{{%booking_stays}}', 'stars');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210219_080519_edit_booking_stays_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210219_080519_edit_booking_stays_fields cannot be reverted.\n";

        return false;
    }
    */
}

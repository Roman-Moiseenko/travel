<?php

use yii\db\Migration;

/**
 * Class m201106_141809_add_booking_cars_fields
 */
class m201106_141809_add_booking_cars_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_cars}}', 'name_en', $this->string());
        $this->addColumn('{{%booking_cars}}', 'description', $this->text());
        $this->addColumn('{{%booking_cars}}', 'description_en', $this->text());
        $this->addColumn('{{%booking_cars}}', 'year', $this->integer()->defaultValue(1970));
        $this->addColumn('{{%booking_cars}}', 'main_photo_id', $this->integer());

        $this->addColumn('{{%booking_cars}}', 'deposit', $this->integer());
        $this->addColumn('{{%booking_cars}}', 'cost', $this->integer());
        $this->addColumn('{{%booking_cars}}', 'cancellation', $this->integer());
        $this->addColumn('{{%booking_cars}}', 'pay_bank', $this->boolean());
        $this->addColumn('{{%booking_cars}}', 'check_booking', $this->integer());

        $this->addColumn('{{%booking_cars}}', 'rating', $this->float());
        $this->addColumn('{{%booking_cars}}', 'views', $this->integer());
        $this->addColumn('{{%booking_cars}}', 'public_at', $this->integer());

        $this->addColumn('{{%booking_cars}}', 'address', 'JSON NOT NULL');
        $this->addColumn('{{%booking_cars}}', 'params_age_on', $this->boolean());
        $this->addColumn('{{%booking_cars}}', 'params_age_min', $this->integer());
        $this->addColumn('{{%booking_cars}}', 'params_age_max', $this->integer());

        $this->addColumn('{{%booking_cars}}', 'params_min_rent', $this->integer());
        $this->addColumn('{{%booking_cars}}', 'params_delivery', $this->boolean());
        $this->addColumn('{{%booking_cars}}', 'params_license', $this->string(5));
        $this->addColumn('{{%booking_cars}}', 'params_experience', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201106_141809_add_booking_cars_fields cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201106_141809_add_booking_cars_fields cannot be reverted.\n";

        return false;
    }
    */
}

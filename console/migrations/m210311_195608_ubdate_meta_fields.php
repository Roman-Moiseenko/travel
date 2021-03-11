<?php

use yii\db\Migration;

/**
 * Class m210311_195608_ubdate_meta_fields
 */
class m210311_195608_ubdate_meta_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%booking_tours}}', ['meta_json' => '']);
        $this->update('{{%booking_cars}}', ['meta_json' => '']);
        $this->update('{{%booking_funs}}', ['meta_json' => '']);
        $this->update('{{%booking_stays}}', ['meta_json' => '']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210311_195608_ubdate_meta_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210311_195608_ubdate_meta_fields cannot be reverted.\n";

        return false;
    }
    */
}

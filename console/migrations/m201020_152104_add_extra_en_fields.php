<?php

use yii\db\Migration;

/**
 * Class m201020_152104_add_extra_en_fields
 */
class m201020_152104_add_extra_en_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_extra}}', 'name_en', $this->string());
        $this->addColumn('{{%booking_tours_extra}}', 'description_en', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_extra}}', 'name_en');
        $this->dropColumn('{{%booking_tours_extra}}', 'description_en');;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201020_152104_add_extra_en_fields cannot be reverted.\n";

        return false;
    }
    */
}

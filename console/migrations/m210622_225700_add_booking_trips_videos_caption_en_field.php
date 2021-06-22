<?php

use yii\db\Migration;

/**
 * Class m210622_225700_add_booking_trips_videos_caption_en_field
 */
class m210622_225700_add_booking_trips_videos_caption_en_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_trips_videos}}', 'caption_en', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210622_225700_add_booking_trips_videos_caption_en_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210622_225700_add_booking_trips_videos_caption_en_field cannot be reverted.\n";

        return false;
    }
    */
}

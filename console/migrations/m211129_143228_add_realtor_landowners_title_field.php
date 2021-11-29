<?php

use yii\db\Migration;

/**
 * Class m211129_143228_add_realtor_landowners_title_field
 */
class m211129_143228_add_realtor_landowners_title_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%realtor_landowners}}', 'title', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211129_143228_add_realtor_landowners_title_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211129_143228_add_realtor_landowners_title_field cannot be reverted.\n";

        return false;
    }
    */
}

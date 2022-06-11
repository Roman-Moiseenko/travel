<?php

use yii\db\Migration;

/**
 * Class m220611_202818_add_medicine_pages_fields
 */
class m220611_202818_add_medicine_pages_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%medicine_pages}}', 'created_at', $this->integer()->notNull());
        $this->update('{{%medicine_pages}}', ['created_at' => strtotime('2022-02-27')]);

        $this->addColumn('{{%medicine_pages}}', 'updated_at', $this->integer());
        $this->update('{{%medicine_pages}}', ['updated_at' => time()]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220611_202818_add_medicine_pages_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220611_202818_add_medicine_pages_fields cannot be reverted.\n";

        return false;
    }
    */
}

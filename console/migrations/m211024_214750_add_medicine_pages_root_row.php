<?php

use booking\helpers\StatusHelper;
use yii\db\Migration;

/**
 * Class m211024_214750_add_medicine_pages_root_row
 */
class m211024_214750_add_medicine_pages_root_row extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%medicine_pages}}', [
            'id' => 1,
            'title' => '',
            'slug' => 'root',
            'content' => null,
            'meta_json' => '{}',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
            'status' => StatusHelper::STATUS_ACTIVE,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211024_214750_add_medicine_pages_root_row cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211024_214750_add_medicine_pages_root_row cannot be reverted.\n";

        return false;
    }
    */
}

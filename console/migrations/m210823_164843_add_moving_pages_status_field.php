<?php

use booking\helpers\StatusHelper;
use yii\db\Migration;

/**
 * Class m210823_164843_add_moving_pages_status_field
 */
class m210823_164843_add_moving_pages_status_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%moving_pages}}', 'status', $this->integer()->defaultValue(StatusHelper::STATUS_DRAFT));
        $this->update('{{%moving_pages}}', ['status' => StatusHelper::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210823_164843_add_moving_pages_status_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210823_164843_add_moving_pages_status_field cannot be reverted.\n";

        return false;
    }
    */
}

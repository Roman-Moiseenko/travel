<?php

use yii\db\Migration;

/**
 * Class m210408_151428_add_shops_deliver_field
 */
class m210408_151428_add_shops_deliver_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops}}', 'delivery_json', 'JSON NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops}}', 'delivery_json');
    }

}

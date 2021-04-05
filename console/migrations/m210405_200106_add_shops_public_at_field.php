<?php

use yii\db\Migration;

/**
 * Class m210405_200106_add_shops_public_at_field
 */
class m210405_200106_add_shops_public_at_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops}}', 'public_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops}}', 'public_at');
    }

}

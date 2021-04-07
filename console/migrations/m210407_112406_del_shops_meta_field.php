<?php

use yii\db\Migration;

/**
 * Class m210407_112406_del_shops_meta_field
 */
class m210407_112406_del_shops_meta_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%shops}}', 'meta_json');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%shops}}', 'meta_json', 'JSON NOT NULL');
    }

}

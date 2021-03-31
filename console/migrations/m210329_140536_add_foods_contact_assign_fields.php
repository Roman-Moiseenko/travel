<?php

use yii\db\Migration;

/**
 * Class m210329_140536_add_foods_contact_assign_fields
 */
class m210329_140536_add_foods_contact_assign_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%foods_contact_assign}}', 'value', $this->string());
        $this->addColumn('{{%foods_contact_assign}}', 'description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%foods_contact_assign}}', 'value');
        $this->dropColumn('{{%foods_contact_assign}}', 'description');
    }

}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead`.
 */
class m170426_165850_create_lead_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('lead', [
            'id' => $this->primaryKey(),
            'click_count' => $this->integer()->notNull()->defaultValue(0),
            'view_count' => $this->integer()->notNull()->defaultValue(0),
            'contact_count' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lead');
    }
}

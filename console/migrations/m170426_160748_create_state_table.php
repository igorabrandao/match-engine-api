<?php

use yii\db\Migration;

/**
 * Handles the creation of table `state`.
 */
class m170426_160748_create_state_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('state', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'abbreviation' => $this->string(2)->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('state');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_market`.
 */
class m170426_163227_create_company_market_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company_market', [
            'id' => $this->primaryKey(),
            'description' => $this->string(64),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('company_market');
    }
}

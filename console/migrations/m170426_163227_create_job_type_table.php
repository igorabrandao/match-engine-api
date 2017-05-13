<?php

use yii\db\Migration;

/**
 * Handles the creation of table `job_type`.
 */
class m170426_163227_create_job_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('job_type', [
            'id' => $this->primaryKey(),
            'description' => $this->string(64),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('job_type');
    }
}

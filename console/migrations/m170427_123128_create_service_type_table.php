<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service_type`.
 */
class m170427_123128_create_service_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('service_type', [
            'id' => $this->primaryKey(),
            'description' => $this->string(255)->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('service_type');
    }
}

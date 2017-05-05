<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional_type`.
 */
class m170426_165407_create_professional_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('professional_type', [
            'id' => $this->primaryKey(),
            'description' => $this->string(255)->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('professional_type');
    }
}

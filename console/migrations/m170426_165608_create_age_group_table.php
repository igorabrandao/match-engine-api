<?php

use yii\db\Migration;

/**
 * Handles the creation of table `age_group`.
 */
class m170426_165608_create_age_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('age_group', [
            'id' => $this->primaryKey(),
            'description' => $this->string(255)->notNull(),
            'min_age' => $this->integer()->notNull(),
            'max_age' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('age_group');
    }
}

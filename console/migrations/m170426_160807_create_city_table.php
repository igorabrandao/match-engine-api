<?php

use yii\db\Migration;

/**
 * Handles the creation of table `city`.
 */
class m170426_160807_create_city_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'state_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'is_capital' => $this->boolean()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_city_state', 'city', 'state_id', 'state', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_city_state', 'city');

        $this->dropTable('city');
    }
}

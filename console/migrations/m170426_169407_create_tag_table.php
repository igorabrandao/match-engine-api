<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m170426_169407_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'description' => $this->string(255)->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tag');
    }
}

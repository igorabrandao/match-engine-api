<?php

use yii\db\Migration;

/**
 * Handles the creation of table `upload`.
 */
class m170426_162750_create_upload_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('upload', [
            'id' => $this->string(13)->unique(),
            'ext' => $this->string(4)->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('upload');
    }
}

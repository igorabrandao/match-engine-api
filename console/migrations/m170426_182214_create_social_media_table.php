<?php

use yii\db\Migration;

/**
 * Handles the creation of table `social_media`.
 */
class m170426_182214_create_social_media_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('social_media', [
            'id' => $this->primaryKey(),
            'facebook' => $this->string(255),
            'twitter' => $this->string(255),
            'google_plus' => $this->string(255),
            'instagram' => $this->string(255),
            'linkedin' => $this->string(255),
            'site' => $this->string(255),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('social_media');
    }
}

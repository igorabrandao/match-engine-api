<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170426_145305_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'is_admin' => $this->boolean()->notNull(),
            'is_active' => $this->boolean()->notNull(),
            'name' => $this->string(255)->notNull(),
            'surname' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'phone' => $this->string(255)->notNull(),
            'access_token' => $this->string(255),
            'password_reset_token' => $this->string(255),
            'encrypted_password' => $this->string(255)->notNull(),
            'expiration_date_reset_token' => $this->timestamp(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}

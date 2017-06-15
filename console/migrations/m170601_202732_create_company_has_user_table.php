<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_has_user`.
 */
class m170601_202732_create_company_has_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company_has_user', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'user_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_has_user-company_id',
            'company_has_user',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_has_user-company_id',
            'company_has_user',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-company_has_user-user_id',
            'company_has_user',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-company_has_user-user_id',
            'company_has_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-company_has_user-company_id',
            'company_has_user'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_has_user-company_id',
            'company_has_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-company_has_user-user_id',
            'company_has_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-company_has_user-user_id',
            'company_has_user'
        );

        $this->dropTable('company_has_user');
    }
}

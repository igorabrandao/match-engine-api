<?php

use yii\db\Migration;

/**
 * Handles the creation of table `job_application`.
 */
class m170426_165350_create_job_application extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('job_application', [
            'id' => $this->primaryKey(),
            'job_id' => $this->integer(),
            'user_id' => $this->integer(),
            'message' => $this->text()->notNull(),
            'is_active' => $this->boolean()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        // creates index for column `job_id`
        $this->createIndex(
            'idx-job_application-job_id',
            'job_application',
            'job_id'
        );

        // add foreign key for table `job`
        $this->addForeignKey(
            'fk-job_application-job_id',
            'job_application',
            'job_id',
            'job',
            'id',
            'RESTRICT'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-job_application-user_id',
            'job_application',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-job_application-user_id',
            'job_application',
            'user_id',
            'user',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `job`
        $this->dropForeignKey(
            'fk-job_application-job_id',
            'job_application'
        );

        // drops index for column `job_id`
        $this->dropIndex(
            'idx-job_application-job_id',
            'job_application'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-job_application-user_id',
            'job_application'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-job_application-user_id',
            'job_application'
        );

        $this->dropTable('job_application');
    }
}
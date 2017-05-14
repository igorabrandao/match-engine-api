<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_has_job`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `job`
 */
class m170514_212507_create_company_has_job_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company_has_job', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'job_id' => $this->integer(),
        ]);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_has_job-company_id',
            'company_has_job',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_has_job-company_id',
            'company_has_job',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `job_id`
        $this->createIndex(
            'idx-company_has_job-job_id',
            'company_has_job',
            'job_id'
        );

        // add foreign key for table `job`
        $this->addForeignKey(
            'fk-company_has_job-job_id',
            'company_has_job',
            'job_id',
            'job',
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
            'fk-company_has_job-company_id',
            'company_has_job'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_has_job-company_id',
            'company_has_job'
        );

        // drops foreign key for table `job`
        $this->dropForeignKey(
            'fk-company_has_job-job_id',
            'company_has_job'
        );

        // drops index for column `job_id`
        $this->dropIndex(
            'idx-company_has_job-job_id',
            'company_has_job'
        );

        $this->dropTable('company_has_job');
    }
}

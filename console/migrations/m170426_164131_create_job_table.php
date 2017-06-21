<?php

use yii\db\Migration;

/**
 * Handles the creation of table `job`.
 * Has foreign keys to the tables:
 *
 * - `city_id`
 * - `job_type_id`
 */
class m170426_164131_create_job_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('job', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'job_type_id' => $this->integer(),
            'city_id' => $this->integer(),
            'rate' => $this->float(),
            'requirement' => $this->text()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'expired_at' => $this->timestamp(),
        ], $tableOptions);

        // creates index for column `job_type_id`
        $this->createIndex(
            'idx-job-job_type_id',
            'job',
            'job_type_id'
        );

        // add foreign key for table `job_type`
        $this->addForeignKey(
            'fk-job-job_type_id',
            'job',
            'job_type_id',
            'job_type',
            'id',
            'RESTRICT'
        );

        // creates index for column `city_id`
        $this->createIndex(
            'idx-job-city_id',
            'job',
            'city_id'
        );

        // add foreign key for table `city_id`
        $this->addForeignKey(
            'fk-job-city_id',
            'job',
            'city_id',
            'city',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `job_type`
        $this->dropForeignKey(
            'fk-job-job_type_id',
            'job'
        );

        // drops index for column `job_type_id`
        $this->dropIndex(
            'idx-job-job_type_id',
            'job'
        );

        // drops foreign key for table `city_id`
        $this->dropForeignKey(
            'fk-job-city_id',
            'job'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            'idx-job-city_id',
            'job'
        );

        $this->dropTable('job');
    }
}

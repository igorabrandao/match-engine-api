<?php

use yii\db\Migration;

/**
 * Handles the creation of table `job_has_tag`.
 * Has foreign keys to the tables:
 *
 * - `job`
 * - `tag`
 */
class m170426_176478_create_job_has_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('job_has_tag', [
            'id' => $this->primaryKey(),
            'job_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `job_id`
        $this->createIndex(
            'idx-job_has_tag-job_id',
            'job_has_tag',
            'job_id'
        );

        // add foreign key for table `job`
        $this->addForeignKey(
            'fk-job_has_tag-job_id',
            'job_has_tag',
            'job_id',
            'job',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-job_has_tag-tag_id',
            'job_has_tag',
            'tag_id'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-job_has_tag-tag_id',
            'job_has_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `job`
        $this->dropForeignKey(
            'fk-job_has_tag-job_id',
            'job_has_tag'
        );

        // drops index for column `job_id`
        $this->dropIndex(
            'idx-job_has_tag-job_id',
            'job_has_tag'
        );

        // drops foreign key for table `tag`
        $this->dropForeignKey(
            'fk-job_has_tag-tag_id',
            'job_has_tag'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-job_has_tag-tag_id',
            'job_has_tag'
        );

        $this->dropTable('job_has_tag');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `job_has_category`.
 * Has foreign keys to the tables:
 *
 * - `job`
 * - `category`
 */
class m170513_232839_create_job_has_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('job_has_category', [
            'id' => $this->primaryKey(),
            'job_id' => $this->integer(),
            'category_id' => $this->integer(),
        ]);

        // creates index for column `job_id`
        $this->createIndex(
            'idx-job_has_category-job_id',
            'job_has_category',
            'job_id'
        );

        // add foreign key for table `job`
        $this->addForeignKey(
            'fk-job_has_category-job_id',
            'job_has_category',
            'job_id',
            'job',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-job_has_category-category_id',
            'job_has_category',
            'category_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-job_has_category-category_id',
            'job_has_category',
            'category_id',
            'category',
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
            'fk-job_has_category-job_id',
            'job_has_category'
        );

        // drops index for column `job_id`
        $this->dropIndex(
            'idx-job_has_category-job_id',
            'job_has_category'
        );

        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-job_has_category-category_id',
            'job_has_category'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-job_has_category-category_id',
            'job_has_category'
        );

        $this->dropTable('job_has_category');
    }
}

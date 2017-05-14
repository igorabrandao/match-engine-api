<?php

use yii\db\Migration;

/**
 * Handles the creation of table `job_alert`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m170513_230640_create_job_alert_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('job_alert', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string(255)->notNull(),
            'keywords' => $this->string(255),
            'frequency' => $this->string(255),
            'is_active' => $this->boolean()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'expire_at' => $this->timestamp(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-job_alert-user_id',
            'job_alert',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-job_alert-user_id',
            'job_alert',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-job_alert-user_id',
            'job_alert'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-job_alert-user_id',
            'job_alert'
        );

        $this->dropTable('job_alert');
    }
}

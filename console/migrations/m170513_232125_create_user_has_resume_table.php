<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_has_resume`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `resume`
 */
class m170513_232125_create_user_has_resume_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_has_resume', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'resume_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_has_resume-user_id',
            'user_has_resume',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_has_resume-user_id',
            'user_has_resume',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `resume_id`
        $this->createIndex(
            'idx-user_has_resume-resume_id',
            'user_has_resume',
            'resume_id'
        );

        // add foreign key for table `resume`
        $this->addForeignKey(
            'fk-user_has_resume-resume_id',
            'user_has_resume',
            'resume_id',
            'resume',
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
            'fk-user_has_resume-user_id',
            'user_has_resume'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_has_resume-user_id',
            'user_has_resume'
        );

        // drops foreign key for table `resume`
        $this->dropForeignKey(
            'fk-user_has_resume-resume_id',
            'user_has_resume'
        );

        // drops index for column `resume_id`
        $this->dropIndex(
            'idx-user_has_resume-resume_id',
            'user_has_resume'
        );

        $this->dropTable('user_has_resume');
    }
}

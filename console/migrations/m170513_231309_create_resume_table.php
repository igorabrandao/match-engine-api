<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `logo`
 */
class m170513_231309_create_resume_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('resume', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'professiona_title' => $this->string(255)->notNull(),
            'resume' => $this->text()->notNull(),
            'education' => $this->text(),
            'work_experience' => $this->text(),
            'language' => $this->text(),
            'rate' => $this->float()->notNull(),
            'photo_id' => $this->string(13),
            'video' => $this->string(255),
            'cep' => $this->string(16),
            'street' => $this->string(255)->notNull(),
            'district' => $this->string(255),
            'address_number' => $this->string(64),
            'logo_id' => $this->string(13),
            'city_id' => $this->integer(),
            'facebook' => $this->string(255),
            'twitter' => $this->string(255),
            'google_plus' => $this->string(255),
            'instagram' => $this->string(255),
            'linkedin' => $this->string(255),
            'site' => $this->string(255),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-resume-user_id',
            'resume',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-resume-user_id',
            'resume',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `photo_id`
        $this->createIndex(
            'idx-resume-photo_id',
            'resume',
            'photo_id'
        );

        // add foreign key for table `logo`
        $this->addForeignKey(
            'fk-resume-photo_id',
            'resume',
            'photo_id',
            'logo',
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
            'fk-resume-user_id',
            'resume'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-resume-user_id',
            'resume'
        );

        // drops foreign key for table `logo`
        $this->dropForeignKey(
            'fk-resume-photo_id',
            'resume'
        );

        // drops index for column `photo_id`
        $this->dropIndex(
            'idx-resume-photo_id',
            'resume'
        );

        $this->dropTable('resume');
    }
}

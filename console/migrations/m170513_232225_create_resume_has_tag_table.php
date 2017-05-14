<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume_has_tag`.
 * Has foreign keys to the tables:
 *
 * - `resume`
 * - `tag`
 */
class m170513_232225_create_resume_has_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('resume_has_tag', [
            'id' => $this->primaryKey(),
            'resume_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        // creates index for column `resume_id`
        $this->createIndex(
            'idx-resume_has_tag-resume_id',
            'resume_has_tag',
            'resume_id'
        );

        // add foreign key for table `resume`
        $this->addForeignKey(
            'fk-resume_has_tag-resume_id',
            'resume_has_tag',
            'resume_id',
            'resume',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-resume_has_tag-tag_id',
            'resume_has_tag',
            'tag_id'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-resume_has_tag-tag_id',
            'resume_has_tag',
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
        // drops foreign key for table `resume`
        $this->dropForeignKey(
            'fk-resume_has_tag-resume_id',
            'resume_has_tag'
        );

        // drops index for column `resume_id`
        $this->dropIndex(
            'idx-resume_has_tag-resume_id',
            'resume_has_tag'
        );

        // drops foreign key for table `tag`
        $this->dropForeignKey(
            'fk-resume_has_tag-tag_id',
            'resume_has_tag'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-resume_has_tag-tag_id',
            'resume_has_tag'
        );

        $this->dropTable('resume_has_tag');
    }
}

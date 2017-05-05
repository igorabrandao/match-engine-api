<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional_has_social_media`.
 * Has foreign keys to the tables:
 *
 * - `professional`
 * - `social_media`
 */
class m170426_185506_create_professional_has_social_media_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('professional_has_social_media', [
            'id' => $this->primaryKey(),
            'professional_id' => $this->integer(),
            'social_media_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-professional_has_social_media-professional_id',
            'professional_has_social_media',
            'professional_id'
        );

        // add foreign key for table `professional`
        $this->addForeignKey(
            'fk-professional_has_social_media-professional_id',
            'professional_has_social_media',
            'professional_id',
            'professional',
            'id',
            'CASCADE'
        );

        // creates index for column `social_media_id`
        $this->createIndex(
            'idx-professional_has_social_media-social_media_id',
            'professional_has_social_media',
            'social_media_id'
        );

        // add foreign key for table `social_media`
        $this->addForeignKey(
            'fk-professional_has_social_media-social_media_id',
            'professional_has_social_media',
            'social_media_id',
            'social_media',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `professional`
        $this->dropForeignKey(
            'fk-professional_has_social_media-professional_id',
            'professional_has_social_media'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-professional_has_social_media-professional_id',
            'professional_has_social_media'
        );

        // drops foreign key for table `social_media`
        $this->dropForeignKey(
            'fk-professional_has_social_media-social_media_id',
            'professional_has_social_media'
        );

        // drops index for column `social_media_id`
        $this->dropIndex(
            'idx-professional_has_social_media-social_media_id',
            'professional_has_social_media'
        );

        $this->dropTable('professional_has_social_media');
    }
}

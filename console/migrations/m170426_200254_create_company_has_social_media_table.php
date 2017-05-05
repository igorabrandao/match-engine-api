<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_has_social_media`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `social_media`
 */
class m170426_200254_create_company_has_social_media_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company_has_social_media', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'social_media_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_has_social_media-company_id',
            'company_has_social_media',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_has_social_media-company_id',
            'company_has_social_media',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `social_media_id`
        $this->createIndex(
            'idx-company_has_social_media-social_media_id',
            'company_has_social_media',
            'social_media_id'
        );

        // add foreign key for table `social_media`
        $this->addForeignKey(
            'fk-company_has_social_media-social_media_id',
            'company_has_social_media',
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
        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-company_has_social_media-company_id',
            'company_has_social_media'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_has_social_media-company_id',
            'company_has_social_media'
        );

        // drops foreign key for table `social_media`
        $this->dropForeignKey(
            'fk-company_has_social_media-social_media_id',
            'company_has_social_media'
        );

        // drops index for column `social_media_id`
        $this->dropIndex(
            'idx-company_has_social_media-social_media_id',
            'company_has_social_media'
        );

        $this->dropTable('company_has_social_media');
    }
}

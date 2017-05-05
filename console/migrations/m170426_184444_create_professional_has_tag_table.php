<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional_has_tag`.
 * Has foreign keys to the tables:
 *
 * - `professional`
 * - `tag`
 */
class m170426_184444_create_professional_has_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('professional_has_tag', [
            'id' => $this->primaryKey(),
            'professional_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-professional_has_tag-professional_id',
            'professional_has_tag',
            'professional_id'
        );

        // add foreign key for table `professional`
        $this->addForeignKey(
            'fk-professional_has_tag-professional_id',
            'professional_has_tag',
            'professional_id',
            'professional',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-professional_has_tag-tag_id',
            'professional_has_tag',
            'tag_id'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-professional_has_tag-tag_id',
            'professional_has_tag',
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
        // drops foreign key for table `professional`
        $this->dropForeignKey(
            'fk-professional_has_tag-professional_id',
            'professional_has_tag'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-professional_has_tag-professional_id',
            'professional_has_tag'
        );

        // drops foreign key for table `tag`
        $this->dropForeignKey(
            'fk-professional_has_tag-tag_id',
            'professional_has_tag'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-professional_has_tag-tag_id',
            'professional_has_tag'
        );

        $this->dropTable('professional_has_tag');
    }
}

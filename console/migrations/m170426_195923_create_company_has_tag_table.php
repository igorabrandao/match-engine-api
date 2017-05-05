<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_has_tag`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `tag`
 */
class m170426_195923_create_company_has_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company_has_tag', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_has_tag-company_id',
            'company_has_tag',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_has_tag-company_id',
            'company_has_tag',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-company_has_tag-tag_id',
            'company_has_tag',
            'tag_id'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-company_has_tag-tag_id',
            'company_has_tag',
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
        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-company_has_tag-company_id',
            'company_has_tag'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_has_tag-company_id',
            'company_has_tag'
        );

        // drops foreign key for table `tag`
        $this->dropForeignKey(
            'fk-company_has_tag-tag_id',
            'company_has_tag'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-company_has_tag-tag_id',
            'company_has_tag'
        );

        $this->dropTable('company_has_tag');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 * Has foreign keys to the tables:
 *
 * - `tag_type`
 */
class m170426_182407_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'description' => $this->string(255)->notNull(),
            'tag_type_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `tag_type_id`
        $this->createIndex(
            'idx-tag-tag_type_id',
            'tag',
            'tag_type_id'
        );

        // add foreign key for table `tag_type`
        $this->addForeignKey(
            'fk-tag-tag_type_id',
            'tag',
            'tag_type_id',
            'tag_type',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `tag_type`
        $this->dropForeignKey(
            'fk-tag-tag_type_id',
            'tag'
        );

        // drops index for column `tag_type_id`
        $this->dropIndex(
            'idx-tag-tag_type_id',
            'tag'
        );

        $this->dropTable('tag');
    }
}

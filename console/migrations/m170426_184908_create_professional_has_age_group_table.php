<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional_has_age_group`.
 * Has foreign keys to the tables:
 *
 * - `professional`
 * - `age_group`
 */
class m170426_184908_create_professional_has_age_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('professional_has_age_group', [
            'id' => $this->primaryKey(),
            'professional_id' => $this->integer(),
            'age_group_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-professional_has_age_group-professional_id',
            'professional_has_age_group',
            'professional_id'
        );

        // add foreign key for table `professional`
        $this->addForeignKey(
            'fk-professional_has_age_group-professional_id',
            'professional_has_age_group',
            'professional_id',
            'professional',
            'id',
            'CASCADE'
        );

        // creates index for column `age_group_id`
        $this->createIndex(
            'idx-professional_has_age_group-age_group_id',
            'professional_has_age_group',
            'age_group_id'
        );

        // add foreign key for table `age_group`
        $this->addForeignKey(
            'fk-professional_has_age_group-age_group_id',
            'professional_has_age_group',
            'age_group_id',
            'age_group',
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
            'fk-professional_has_age_group-professional_id',
            'professional_has_age_group'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-professional_has_age_group-professional_id',
            'professional_has_age_group'
        );

        // drops foreign key for table `age_group`
        $this->dropForeignKey(
            'fk-professional_has_age_group-age_group_id',
            'professional_has_age_group'
        );

        // drops index for column `age_group_id`
        $this->dropIndex(
            'idx-professional_has_age_group-age_group_id',
            'professional_has_age_group'
        );

        $this->dropTable('professional_has_age_group');
    }
}

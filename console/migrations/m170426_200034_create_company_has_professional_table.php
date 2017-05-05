<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_has_professional`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `professional`
 */
class m170426_200034_create_company_has_professional_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company_has_professional', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'professional_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_has_professional-company_id',
            'company_has_professional',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_has_professional-company_id',
            'company_has_professional',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-company_has_professional-professional_id',
            'company_has_professional',
            'professional_id'
        );

        // add foreign key for table `professional`
        $this->addForeignKey(
            'fk-company_has_professional-professional_id',
            'company_has_professional',
            'professional_id',
            'professional',
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
            'fk-company_has_professional-company_id',
            'company_has_professional'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_has_professional-company_id',
            'company_has_professional'
        );

        // drops foreign key for table `professional`
        $this->dropForeignKey(
            'fk-company_has_professional-professional_id',
            'company_has_professional'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-company_has_professional-professional_id',
            'company_has_professional'
        );

        $this->dropTable('company_has_professional');
    }
}

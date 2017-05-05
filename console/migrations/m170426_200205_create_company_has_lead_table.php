<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_has_lead`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `lead`
 */
class m170426_200205_create_company_has_lead_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company_has_lead', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'lead_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_has_lead-company_id',
            'company_has_lead',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_has_lead-company_id',
            'company_has_lead',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `lead_id`
        $this->createIndex(
            'idx-company_has_lead-lead_id',
            'company_has_lead',
            'lead_id'
        );

        // add foreign key for table `lead`
        $this->addForeignKey(
            'fk-company_has_lead-lead_id',
            'company_has_lead',
            'lead_id',
            'lead',
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
            'fk-company_has_lead-company_id',
            'company_has_lead'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_has_lead-company_id',
            'company_has_lead'
        );

        // drops foreign key for table `lead`
        $this->dropForeignKey(
            'fk-company_has_lead-lead_id',
            'company_has_lead'
        );

        // drops index for column `lead_id`
        $this->dropIndex(
            'idx-company_has_lead-lead_id',
            'company_has_lead'
        );

        $this->dropTable('company_has_lead');
    }
}

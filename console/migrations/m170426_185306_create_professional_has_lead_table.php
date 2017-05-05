<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional_has_lead`.
 * Has foreign keys to the tables:
 *
 * - `professional`
 * - `lead`
 */
class m170426_185306_create_professional_has_lead_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('professional_has_lead', [
            'id' => $this->primaryKey(),
            'professional_id' => $this->integer(),
            'lead_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-professional_has_lead-professional_id',
            'professional_has_lead',
            'professional_id'
        );

        // add foreign key for table `professional`
        $this->addForeignKey(
            'fk-professional_has_lead-professional_id',
            'professional_has_lead',
            'professional_id',
            'professional',
            'id',
            'CASCADE'
        );

        // creates index for column `lead_id`
        $this->createIndex(
            'idx-professional_has_lead-lead_id',
            'professional_has_lead',
            'lead_id'
        );

        // add foreign key for table `lead`
        $this->addForeignKey(
            'fk-professional_has_lead-lead_id',
            'professional_has_lead',
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
        // drops foreign key for table `professional`
        $this->dropForeignKey(
            'fk-professional_has_lead-professional_id',
            'professional_has_lead'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-professional_has_lead-professional_id',
            'professional_has_lead'
        );

        // drops foreign key for table `lead`
        $this->dropForeignKey(
            'fk-professional_has_lead-lead_id',
            'professional_has_lead'
        );

        // drops index for column `lead_id`
        $this->dropIndex(
            'idx-professional_has_lead-lead_id',
            'professional_has_lead'
        );

        $this->dropTable('professional_has_lead');
    }
}

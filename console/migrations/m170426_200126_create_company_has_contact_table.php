<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_has_contact`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `contact`
 */
class m170426_200126_create_company_has_contact_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company_has_contact', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'professional_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_has_contact-company_id',
            'company_has_contact',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_has_contact-company_id',
            'company_has_contact',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-company_has_contact-professional_id',
            'company_has_contact',
            'professional_id'
        );

        // add foreign key for table `contact`
        $this->addForeignKey(
            'fk-company_has_contact-professional_id',
            'company_has_contact',
            'professional_id',
            'contact',
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
            'fk-company_has_contact-company_id',
            'company_has_contact'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_has_contact-company_id',
            'company_has_contact'
        );

        // drops foreign key for table `contact`
        $this->dropForeignKey(
            'fk-company_has_contact-professional_id',
            'company_has_contact'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-company_has_contact-professional_id',
            'company_has_contact'
        );

        $this->dropTable('company_has_contact');
    }
}

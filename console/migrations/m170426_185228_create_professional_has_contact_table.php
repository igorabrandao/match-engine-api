<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional_has_contact`.
 * Has foreign keys to the tables:
 *
 * - `professional`
 * - `contact`
 */
class m170426_185228_create_professional_has_contact_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('professional_has_contact', [
            'id' => $this->primaryKey(),
            'professional_id' => $this->integer(),
            'contact_id' => $this->integer(),
        ]);

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-professional_has_contact-professional_id',
            'professional_has_contact',
            'professional_id'
        );

        // add foreign key for table `professional`
        $this->addForeignKey(
            'fk-professional_has_contact-professional_id',
            'professional_has_contact',
            'professional_id',
            'professional',
            'id',
            'CASCADE'
        );

        // creates index for column `contact_id`
        $this->createIndex(
            'idx-professional_has_contact-contact_id',
            'professional_has_contact',
            'contact_id'
        );

        // add foreign key for table `contact`
        $this->addForeignKey(
            'fk-professional_has_contact-contact_id',
            'professional_has_contact',
            'contact_id',
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
        // drops foreign key for table `professional`
        $this->dropForeignKey(
            'fk-professional_has_contact-professional_id',
            'professional_has_contact'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-professional_has_contact-professional_id',
            'professional_has_contact'
        );

        // drops foreign key for table `contact`
        $this->dropForeignKey(
            'fk-professional_has_contact-contact_id',
            'professional_has_contact'
        );

        // drops index for column `contact_id`
        $this->dropIndex(
            'idx-professional_has_contact-contact_id',
            'professional_has_contact'
        );

        $this->dropTable('professional_has_contact');
    }
}

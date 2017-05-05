<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional_has_service_type`.
 * Has foreign keys to the tables:
 *
 * - `professional`
 * - `service_type`
 */
class m170427_123354_create_professional_has_service_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('professional_has_service_type', [
            'id' => $this->primaryKey(),
            'professional_id' => $this->integer()->notNull(),
            'service_type_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-professional_has_service_type-professional_id',
            'professional_has_service_type',
            'professional_id'
        );

        // add foreign key for table `professional`
        $this->addForeignKey(
            'fk-professional_has_service_type-professional_id',
            'professional_has_service_type',
            'professional_id',
            'professional',
            'id',
            'CASCADE'
        );

        // creates index for column `service_type_id`
        $this->createIndex(
            'idx-professional_has_service_type-service_type_id',
            'professional_has_service_type',
            'service_type_id'
        );

        // add foreign key for table `service_type`
        $this->addForeignKey(
            'fk-professional_has_service_type-service_type_id',
            'professional_has_service_type',
            'service_type_id',
            'service_type',
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
            'fk-professional_has_service_type-professional_id',
            'professional_has_service_type'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-professional_has_service_type-professional_id',
            'professional_has_service_type'
        );

        // drops foreign key for table `service_type`
        $this->dropForeignKey(
            'fk-professional_has_service_type-service_type_id',
            'professional_has_service_type'
        );

        // drops index for column `service_type_id`
        $this->dropIndex(
            'idx-professional_has_service_type-service_type_id',
            'professional_has_service_type'
        );

        $this->dropTable('professional_has_service_type');
    }
}

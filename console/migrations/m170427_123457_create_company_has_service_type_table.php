<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_has_service_type`.
 * Has foreign keys to the tables:
 *
 * - `company`
 * - `service_type`
 */
class m170427_123457_create_company_has_service_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company_has_service_type', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'service_type_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `company_id`
        $this->createIndex(
            'idx-company_has_service_type-company_id',
            'company_has_service_type',
            'company_id'
        );

        // add foreign key for table `company`
        $this->addForeignKey(
            'fk-company_has_service_type-company_id',
            'company_has_service_type',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        // creates index for column `service_type_id`
        $this->createIndex(
            'idx-company_has_service_type-service_type_id',
            'company_has_service_type',
            'service_type_id'
        );

        // add foreign key for table `service_type`
        $this->addForeignKey(
            'fk-company_has_service_type-service_type_id',
            'company_has_service_type',
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
        // drops foreign key for table `company`
        $this->dropForeignKey(
            'fk-company_has_service_type-company_id',
            'company_has_service_type'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            'idx-company_has_service_type-company_id',
            'company_has_service_type'
        );

        // drops foreign key for table `service_type`
        $this->dropForeignKey(
            'fk-company_has_service_type-service_type_id',
            'company_has_service_type'
        );

        // drops index for column `service_type_id`
        $this->dropIndex(
            'idx-company_has_service_type-service_type_id',
            'company_has_service_type'
        );

        $this->dropTable('company_has_service_type');
    }
}

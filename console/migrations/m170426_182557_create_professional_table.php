<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional`.
 * Has foreign keys to the tables:
 *
 * - `professional_type`
 */
class m170426_182557_create_professional_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('professional', [
            'id' => $this->primaryKey(),
            'female' => $this->boolean()->notNull(),
            'about' => $this->text(),
            'professional_type_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `professional_type_id`
        $this->createIndex(
            'idx-professional-professional_type_id',
            'professional',
            'professional_type_id'
        );

        // add foreign key for table `professional_type`
        $this->addForeignKey(
            'fk-professional-professional_type_id',
            'professional',
            'professional_type_id',
            'professional_type',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `professional_type`
        $this->dropForeignKey(
            'fk-professional-professional_type_id',
            'professional'
        );

        // drops index for column `professional_type_id`
        $this->dropIndex(
            'idx-professional-professional_type_id',
            'professional'
        );

        $this->dropTable('professional');
    }
}

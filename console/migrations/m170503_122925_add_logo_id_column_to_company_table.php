<?php

use yii\db\Migration;

/**
 * Handles adding logo_id to table `company`.
 * Has foreign keys to the tables:
 *
 * - `upload`
 */
class m170503_122925_add_logo_id_column_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'logo_id', $this->string(13));

        // creates index for column `logo_id`
        $this->createIndex(
            'idx-company-logo_id',
            'company',
            'logo_id'
        );

        // add foreign key for table `upload`
        $this->addForeignKey(
            'fk-company-logo_id',
            'company',
            'logo_id',
            'upload',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `upload`
        $this->dropForeignKey(
            'fk-company-logo_id',
            'company'
        );

        // drops index for column `logo_id`
        $this->dropIndex(
            'idx-company-logo_id',
            'company'
        );

        $this->dropColumn('company', 'logo_id');
    }
}

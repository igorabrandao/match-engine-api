<?php

use yii\db\Migration;

/**
 * Handles dropping photo_id from table `company`.
 */
class m170503_121231_drop_photo_id_column_from_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // drops foreign key for table `photo`
        $this->dropForeignKey(
            'fk-company-photo_id',
            'company'
        );

        // drops index for column `logo`
        $this->dropIndex(
            'idx-company-photo_id',
            'company'
        );

        $this->dropColumn('company', 'photo_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('company', 'photo_id', $this->string(13));

        // creates index for column `photo`
        $this->createIndex(
            'idx-company-photo_id',
            'company',
            'photo_id'
        );

        // add foreign key for table `photo`
        $this->addForeignKey(
            'fk-company-photo_id',
            'company',
            'photo_id',
            'photo',
            'id',
            'RESTRICT'
        );
    }
}

<?php

use yii\db\Migration;

/**
 * Handles adding price_range_id to table `company`.
 * Has foreign keys to the tables:
 *
 * - `price_range`
 */
class m170503_115245_add_price_range_id_column_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'price_range_id', $this->integer());

        // creates index for column `price_range_id`
        $this->createIndex(
            'idx-company-price_range_id',
            'company',
            'price_range_id'
        );

        // add foreign key for table `price_range`
        $this->addForeignKey(
            'fk-company-price_range_id',
            'company',
            'price_range_id',
            'price_range',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `price_range`
        $this->dropForeignKey(
            'fk-company-price_range_id',
            'company'
        );

        // drops index for column `price_range_id`
        $this->dropIndex(
            'idx-company-price_range_id',
            'company'
        );

        $this->dropColumn('company', 'price_range_id');
    }
}

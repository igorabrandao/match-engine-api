<?php

use yii\db\Migration;

/**
 * Handles adding price_range_id to table `professional`.
 * Has foreign keys to the tables:
 *
 * - `price_range`
 */
class m170503_115149_add_price_range_id_column_to_professional_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('professional', 'price_range_id', $this->integer());

        // creates index for column `price_range_id`
        $this->createIndex(
            'idx-professional-price_range_id',
            'professional',
            'price_range_id'
        );

        // add foreign key for table `price_range`
        $this->addForeignKey(
            'fk-professional-price_range_id',
            'professional',
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
            'fk-professional-price_range_id',
            'professional'
        );

        // drops index for column `price_range_id`
        $this->dropIndex(
            'idx-professional-price_range_id',
            'professional'
        );

        $this->dropColumn('professional', 'price_range_id');
    }
}

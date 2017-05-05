<?php

use yii\db\Migration;

/**
 * Handles adding complement to table `company`.
 */
class m170504_142453_add_complement_column_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'complement', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('company', 'complement');
    }
}

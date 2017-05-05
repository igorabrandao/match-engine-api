<?php

use yii\db\Migration;

/**
 * Handles adding latitude to table `company`.
 */
class m170428_121618_add_latitude_column_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'latitude', $this->string(18));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('company', 'latitude');
    }
}

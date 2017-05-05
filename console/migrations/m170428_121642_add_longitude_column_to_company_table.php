<?php

use yii\db\Migration;

/**
 * Handles adding longitude to table `company`.
 */
class m170428_121642_add_longitude_column_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'longitude', $this->string(18));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('company', 'longitude');
    }
}

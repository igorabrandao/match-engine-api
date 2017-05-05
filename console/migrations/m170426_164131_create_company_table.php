<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company`.
 * Has foreign keys to the tables:
 *
 * - `photo`
 * - `company_market`
 */
class m170426_164131_create_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('company', [
            'id' => $this->primaryKey(),
            'cnpj' => $this->string(255)->notNull(),
            'trading_name' => $this->string(255)->notNull(),
            'company_name' => $this->string(255)->notNull(),
            'about' => $this->text(),
            'cep' => $this->string(16),
            'street' => $this->string(255)->notNull(),
            'district' => $this->string(255),
            'address_number' => $this->string(64),
            'photo_id' => $this->string(13),
            'company_market_id' => $this->integer(),
            'city_id' => $this->integer(),
        ], $tableOptions);

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

        // creates index for column `company_market_id`
        $this->createIndex(
            'idx-company-company_market_id',
            'company',
            'company_market_id'
        );

        // add foreign key for table `company_market`
        $this->addForeignKey(
            'fk-company-company_market_id',
            'company',
            'company_market_id',
            'company_market',
            'id',
            'RESTRICT'
        );

        // creates index for column `city_id`
        $this->createIndex(
            'idx-company-city_id',
            'company',
            'city_id'
        );

        // add foreign key for table `city_id`
        $this->addForeignKey(
            'fk-company-city_id',
            'company',
            'city_id',
            'city',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
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

        // drops foreign key for table `company_market`
        $this->dropForeignKey(
            'fk-company-company_market_id',
            'company'
        );

        // drops index for column `company_market_id`
        $this->dropIndex(
            'idx-company-company_market_id',
            'company'
        );

        // drops foreign key for table `city_id`
        $this->dropForeignKey(
            'fk-company-city_id',
            'company'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            'idx-company-city_id',
            'company'
        );

        $this->dropTable('company');
    }
}

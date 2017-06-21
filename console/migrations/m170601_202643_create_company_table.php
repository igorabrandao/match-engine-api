<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company`.
 */
class m170601_202643_create_company_table extends Migration
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
            'upload_id' => $this->string(13),
            'city_id' => $this->integer(),
            'facebook' => $this->string(255),
            'twitter' => $this->string(255),
            'google_plus' => $this->string(255),
            'instagram' => $this->string(255),
            'linkedin' => $this->string(255),
            'site' => $this->string(255),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        // creates index for column `upload`
        $this->createIndex(
            'idx-company-upload_id',
            'company',
            'upload_id'
        );

        // add foreign key for table `upload`
        $this->addForeignKey(
            'fk-company-upload_id',
            'company',
            'upload_id',
            'upload',
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
        // drops foreign key for table `upload`
        $this->dropForeignKey(
            'fk-company-upload_id',
            'company'
        );

        // drops index for column `upload`
        $this->dropIndex(
            'idx-company-upload_id',
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
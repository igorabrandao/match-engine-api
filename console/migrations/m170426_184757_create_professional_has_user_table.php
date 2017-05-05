<?php

use yii\db\Migration;

/**
 * Handles the creation of table `professional_has_user`.
 * Has foreign keys to the tables:
 *
 * - `professional`
 * - `user`
 */
class m170426_184757_create_professional_has_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('professional_has_user', [
            'id' => $this->primaryKey(),
            'professional_id' => $this->integer(),
            'user_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `professional_id`
        $this->createIndex(
            'idx-professional_has_user-professional_id',
            'professional_has_user',
            'professional_id'
        );

        // add foreign key for table `professional`
        $this->addForeignKey(
            'fk-professional_has_user-professional_id',
            'professional_has_user',
            'professional_id',
            'professional',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-professional_has_user-user_id',
            'professional_has_user',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-professional_has_user-user_id',
            'professional_has_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `professional`
        $this->dropForeignKey(
            'fk-professional_has_user-professional_id',
            'professional_has_user'
        );

        // drops index for column `professional_id`
        $this->dropIndex(
            'idx-professional_has_user-professional_id',
            'professional_has_user'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-professional_has_user-user_id',
            'professional_has_user'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-professional_has_user-user_id',
            'professional_has_user'
        );

        $this->dropTable('professional_has_user');
    }
}

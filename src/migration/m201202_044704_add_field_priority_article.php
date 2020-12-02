<?php

use yii\db\Migration;

/**
 * Class m201202_044704_add_field_priority_article
 */
class m201202_044704_add_field_priority_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = Yii::$app->db->getTableSchema('article')->columns;
        if (is_array($columns) && !array_key_exists('priority', $columns)) {
            $this->addColumn('article', 'priority', $this->float()->null()->defaultValue(0.6)->after('hot'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201202_044704_add_field_priority_article cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201202_044704_add_field_priority_article cannot be reverted.\n";

        return false;
    }
    */
}

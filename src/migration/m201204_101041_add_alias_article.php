<?php

use yii\db\Migration;

/**
 * Class m201204_101041_add_alias_article
 */
class m201204_101041_add_alias_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns_article_category = Yii::$app->db->getTableSchema('article_category')->columns;
        if (is_array($columns_article_category) && !array_key_exists('alias', $columns_article_category)) {
            $this->addColumn('article_category', 'alias', $this->string(255)->null());
        }
        $columns_article = Yii::$app->db->getTableSchema('article')->columns;
        if (is_array($columns_article) && !array_key_exists('alias', $columns_article)) {
            $this->addColumn('article', 'alias', $this->string(255)->null());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201204_101041_add_alias_article cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201204_101041_add_alias_article cannot be reverted.\n";

        return false;
    }
    */
}

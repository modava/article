<?php

use yii\db\Migration;

/**
 * Class m201204_181813_add_tags_article
 */
class m201204_181813_add_tags_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns_article = Yii::$app->db->getTableSchema('article')->columns;
        if (is_array($columns_article) && !array_key_exists('tags', $columns_article)) {
            $this->addColumn('article', 'tags', $this->json()->after('views')->null());
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
        echo "m201204_181813_add_tags_article cannot be reverted.\n";

        return false;
    }
    */
}

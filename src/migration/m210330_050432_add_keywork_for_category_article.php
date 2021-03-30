<?php

use yii\db\Migration;

/**
 * Class m210330_050432_add_keywork_for_category_article
 */
class m210330_050432_add_keywork_for_category_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns_article = Yii::$app->db->getTableSchema('article_category')->columns;
        if (is_array($columns_article) && !array_key_exists('key_work', $columns_article)) {
            $this->addColumn('article_category', 'key_work', $this->json()->after('description')->null());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}

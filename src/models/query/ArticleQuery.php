<?php

namespace modava\article\models\query;

use modava\article\models\Article;

/**
 * This is the ActiveQuery class for [[ArticleCategory]].
 *
 * @see ArticleCategory
 */
class ArticleQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([Article::tableName() . '.status' => Article::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([Article::tableName() . '.status' => Article::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }
}

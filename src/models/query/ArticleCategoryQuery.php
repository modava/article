<?php

namespace modava\article\models\query;

use modava\article\models\ArticleCategory;

/**
 * This is the ActiveQuery class for [[ArticleCategory]].
 *
 * @see ArticleCategory
 */
class ArticleCategoryQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([ArticleCategory::tableName() . '.status' => ArticleCategory::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([ArticleCategory::tableName() . '.status' => ArticleCategory::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }
}

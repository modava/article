<?php

namespace modava\article\models\query;

use modava\article\models\ArticleType;

/**
 * This is the ActiveQuery class for [[ArticleCategory]].
 *
 * @see ArticleCategory
 */
class ArticleTypeQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        return $this->andWhere([ArticleType::tableName() . '.status' => ArticleType::STATUS_PUBLISHED]);
    }

    public function disabled()
    {
        return $this->andWhere([ArticleType::tableName() . '.status' => ArticleType::STATUS_DISABLED]);
    }

    public function sortDescById()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }
}

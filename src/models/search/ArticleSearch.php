<?php

namespace modava\article\models\search;

use modava\article\models\table\ActicleCategoryTable;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modava\article\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `modava\article\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * {@inheritdoc}
     */
    public $btn_search = 2;

    public function rules()
    {
        return [
            [['id', 'category_id', 'type_id', 'position', 'status', 'hot', 'views', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'slug', 'image', 'description', 'content', 'ads_pixel', 'ads_session', 'language', 'btn_search'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'position' => $this->position,
            'status' => $this->status,
            'views' => $this->views,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'ads_pixel', $this->ads_pixel])
            ->andFilterWhere(['like', 'ads_session', $this->ads_session])
            ->andFilterWhere(['like', 'language', $this->language]);

        if ($this->category_id != null) {
            $mod = new ActicleCategoryTable();
            $result = [
                $this->category_id => ''
            ];
            $mod->getCategories(ActicleCategoryTable::getAllArticleCategoryArray(), $this->category_id, '', $result);
            $query->andFilterWhere(['category_id' => array_keys($result)]);
        }

        return $dataProvider;
    }
}

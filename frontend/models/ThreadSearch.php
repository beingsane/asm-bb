<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Thread;
use common\models\Tag;
use common\models\ThreadTag;

/**
 * ThreadSearch represents the model behind the search form about `common\models\Thread`.
 */
class ThreadSearch extends Thread
{
    public $tag;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'tag'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $this->load($params);

        if ($this->tag) {
            $tag = Tag::findOne(['name' => $this->tag]);
            if ($tag) {
                $query = $tag->getThreads();
            } else {
                $query = Thread::find()->where('0=1');
            }
        } else {
            $query = Thread::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->with('comments');
        $query->with('user');
        $query->with('joinedUsers');

        // add conditions that should always apply here


        $dataProvider->sort->attributes['user.username'] = [
            'asc'  => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $query->joinWith('user');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}

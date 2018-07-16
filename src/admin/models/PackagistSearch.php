<?php

namespace admin\models;

use common\models\Packagist;
use yii\data\ActiveDataProvider;

class PackagistSearch extends Packagist
{
    public function rules()
    {
        return [
            [['vendor', 'package'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Packagist::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'vendor', $this->vendor])
            ->andFilterWhere(['like', 'package', $this->package]);

        return $dataProvider;
    }
}

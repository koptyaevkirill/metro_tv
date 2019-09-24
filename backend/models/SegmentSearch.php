<?php
namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Segment;


/**
 * Segment model
 *
 * @property integer $id
 */
class SegmentSearch extends Segment
{
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Segment::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC], 'attributes' => ['id']]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'title' => $this->title,
            'valid_from' => $this->valid_from,
            'valid_to' => $this->valid_to,
            'updated_at' => $this->updated_at,
        ]);
        return $dataProvider;
    }
}

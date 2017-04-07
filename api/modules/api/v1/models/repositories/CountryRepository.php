<?php

namespace api\modules\api\v1\models\repositories;

use yii\mongodb\ActiveQuery;

class CountryRepository extends ActiveQuery
{
    public function findByISO2Code($iso2)
    {
        return $this->where(['iso2' => $iso2])->one();
    }

    public function findByISO2CodeAndStateISO2($iso2, $stateIso2)
    {
        return $this->where([
            'iso2' => $iso2,
            'states' => [
                '$elemMatch' => [
                    'iso2' => $stateIso2
                ]
            ]
        ])->one();
    }
}

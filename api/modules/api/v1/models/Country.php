<?php

namespace api\modules\api\v1\models;

use yii2tech\embedded\mongodb\ActiveRecord;

class Country extends ActiveRecord
{
    public function fields()
    {
        return [
            '_id',
            'name',
            'iso2',
            'states'
        ];
    }

    public function attributes()
    {
        return [
            '_id',
            'name',
            'iso2',
            'states'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'iso2'], 'required'],
            [['name', 'iso2'], 'string'],
//            ['states', 'yii2tech\embedded\Validator']
        ];
    }

    public function embedStates()
    {
        return $this->mapEmbeddedList('states', State::className());
    }
}
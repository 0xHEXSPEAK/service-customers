<?php

namespace api\modules\api\v1\models;

use api\modules\api\v1\models\repositories\CountryRepository;
use yii2tech\embedded\mongodb\ActiveRecord;
use yii2tech\embedded\Validator as EmbedValidator;

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
            ['statesData', EmbedValidator::className()]
        ];
    }

    public static function find()
    {
        return new CountryRepository(get_called_class());
    }

    public static function collectionName()
    {
        return 'countries';
    }

    public function embedStatesData()
    {
        return $this->mapEmbeddedList('states', State::className());
    }
}

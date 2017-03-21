<?php

namespace api\modules\api\v1\models;

use yii2tech\embedded\Validator as EmbedValidator;
use yii2tech\embedded\mongodb\ActiveRecord;

class Address extends ActiveRecord
{
    public $street;

    public $city;

    public $zipCode;

    public $state;

    public $country;

    public $phone;

    public function rules()
    {
        return [
            [['street', 'city', 'zipCode'], 'string'],
            [['phone'], 'number'],
            [['stateData', 'countryData'], EmbedValidator::className()]
        ];
    }

    public function embedStateData()
    {
        return $this->mapEmbedded('state', State::className());
    }

    public function embedCountryData()
    {
        return $this->mapEmbedded('country', Country::className());
    }
}
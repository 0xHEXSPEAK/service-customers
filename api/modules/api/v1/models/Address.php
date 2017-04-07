<?php

namespace api\modules\api\v1\models;

use yii\base\Model;

class Address extends Model
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
            [['street', 'city', 'zipCode', ], 'string'],
            [['phone'], 'number'],
            [['state', 'country'], 'string', 'min' => 2],
            [['street', 'country', 'state', 'zipCode'], 'required']
        ];
    }
}
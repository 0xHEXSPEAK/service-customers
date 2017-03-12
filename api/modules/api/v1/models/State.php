<?php

namespace api\modules\api\v1\models;

use yii\base\Model;

class State extends Model
{
    public $name;

    public $iso2;

    public function rules()
    {
        return [
            [['name', 'iso2'], 'required'],
            [['name', 'iso2'], 'string'],
        ];
    }
}
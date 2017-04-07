<?php

namespace api\modules\api\v1\models;

use yii2tech\embedded\mongodb\ActiveRecord;
use yii2tech\embedded\Validator as EmbedValidator;
use yii2tech\embedded\Mapping;

/**
 * Class Customer
 *
 * @package api\modules\api\v1\models
 */
class Customer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'customers';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'firstname',
            'lastname',
            'email',
            'password',
            'addresses',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'password'], 'required'],
            [['firstname', 'lastname', 'password'], 'string'],
            [['email'], 'email'],
        ];
    }

    /**
     * Returns embed documents mongoDB mapping
     * @return Mapping
     */
    public function embedAddressesData()
    {
        return $this->mapEmbeddedList('addresses', Address::className());
    }
}

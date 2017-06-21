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

    const SCENARIO_OAUTH = 'oauthSync';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

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
            'addresses',

            // For sync with oauth2 server
            '_id_oauth',
            'password',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email'], 'required'],
            [['firstname', 'lastname'], 'string'],
            [['email'], 'email'],
            [['password'], 'required', 'on' => self::SCENARIO_OAUTH]
        ];
    }

    public function scenarios()
    {
        $scenarios =  parent::scenarios();
        $scenarios[self::SCENARIO_OAUTH]    = ['firstname', 'lastname', 'email', 'password'];
        $scenarios[self::SCENARIO_CREATE]   = ['firstname', 'lastname', 'email', '_id_oauth'];
        $scenarios[self::SCENARIO_UPDATE]   = ['firstname', 'lastname', 'email', 'addresses'];

        return $scenarios;
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

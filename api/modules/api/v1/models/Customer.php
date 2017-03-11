<?php

namespace api\modules\api\v1\models;

use yii\mongodb\ActiveRecord;

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
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return [
            '_id',
            'firstname',
            'lastname',
            'email',
            'default_address_id',
            'default_billing_address_id'
        ];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [
                [
                    'firstname',
                    'lastname',
                    'email',
                ],
                'required'
            ],
        ];
    }
}

<?php

namespace api\modules\api\v1\models\resources;

use api\modules\api\v1\models\Customer;

class CustomerResource extends Customer
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            '_id',
            'firstname',
            'lastname',
            'email',
            'addresses',
        ];
    }
}
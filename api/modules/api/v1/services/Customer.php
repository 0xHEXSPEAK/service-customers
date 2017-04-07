<?php

namespace api\modules\api\v1\services;

use api\modules\api\v1\models\Address;
use api\modules\api\v1\models\repositories\CountryRepository;
use api\modules\api\v1\models\Customer as CustomerModel;
use yii\base\InvalidValueException;
use yii\web\Request;

/**
 * Class Customer
 *
 * @package api\modules\api\v1\services
 */
class Customer implements CustomerInterface
{
    public function addAddress(
        CountryRepository $countryRepository,
        CustomerModel $customer,
        Address $address,
        Request $request
    ) {
        if ( //checks if specified combination with country and state code are actually exists.
            !$countryRepository->findByISO2CodeAndStateISO2(
                $request->getBodyParam('country'),
                $request->getBodyParam('state')
            )
        ) {
            throw new InvalidValueException('Invalid country ISO2 or state ISO2 code.');
        }

        if ( //validates address and checks if customer variable exists.
            $address->load($request->getBodyParams(), '') &&
            $address->validate() &&
            $customer
        ) {
            $customer->addressesData[] = $address;
            $customer->save();
            return $customer;
        }

        return $address;
    }

    public function getAddress(CustomerModel $customer, $addressId)
    {
        if (isset($customer->addressesData[$addressId])) {
            return $customer->addressesData[$addressId];
        }

        throw new InvalidValueException('Address with specified ID not found.');
    }
}

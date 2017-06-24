<?php

namespace api\modules\api\v1\services;

use api\modules\api\v1\clients\Oauth;
use yii\base\InvalidValueException;
use yii\web\Request;
use api\modules\api\v1\models\Address;
use api\modules\api\v1\models\repositories\CountryRepository;
use api\modules\api\v1\models\Customer as CustomerModel;

/**
 * @package api\modules\api\v1\services
 */
class Customer implements CustomerInterface
{
    /**
     * @inheritdoc
     */
    public function addAddress(
        CountryRepository $countryRepository,
        CustomerModel $customer,
        Address $address,
        Request $request
    ) {
        if (!$this->validateAddress($countryRepository, $address, $request)) {
            return $address;
        }

        $customer->addressesData[] = $address;
        $customer->save();
        return $customer;
    }

    /**
     * @inheritdoc
     */
    public function getAddress(CustomerModel $customer, $addressId)
    {
        if (isset($customer->addressesData[$addressId])) {
            return $customer->addressesData[$addressId];
        }

        throw new InvalidValueException('Address with specified ID not found.');
    }

    /**
     * @inheritdoc
     */
    public function deleteAddress(CustomerModel $customer, $addressId)
    {
        $this->getAddress($customer, $addressId);
        unset($customer->addressesData[$addressId]);
    }

    /**
     * @inheritdoc
     */
    public function updateAddress(
        CountryRepository $countryRepository,
        CustomerModel $customer,
        Address $address,
        Request $request,
        $addressId
    ) {
        if ($this->validateAddress($countryRepository, $address, $request)) {
            $this->getAddress($customer, $addressId);
            $customer->addressesData[$addressId] = $address;
        }

        return $address;
    }

    /**
     * @inheritdoc
     */
    public function createCustomer(CustomerModel $customer, Oauth $oauthClient, Request $request)
    {
        $customer->setScenario(CustomerModel::SCENARIO_OAUTH);
        $customer->load($request->getBodyParams(), '');

        if ($customer->validate()) {
            $oAuthUser = $oauthClient->register($customer);

            unset($customer->password);
            $customer->setScenario(CustomerModel::SCENARIO_CREATE);
            $customer->load($request->getBodyParams() + [
                '_id_oauth' => $oAuthUser->id
            ], '');
            $customer->save();
        }

        return $customer;
    }

    /**
     * @inheritdoc
     */
    public function validateAddress(CountryRepository $countryRepository, Address &$address, Request $request)
    {
        if ( //checks if specified combination with country and state code are actually exists.
        !$countryRepository->findByISO2CodeAndStateISO2(
            $request->getBodyParam('country'),
            $request->getBodyParam('state')
        )
        ) {
            throw new InvalidValueException('Invalid country ISO2 or state ISO2 code.');
        }

        return $address->load($request->getBodyParams(), '') && $address->validate();
    }
}

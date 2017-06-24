<?php

namespace api\modules\api\v1\services;

use api\modules\api\v1\clients\Oauth;
use yii\web\Request;
use api\modules\api\v1\models\Address;
use api\modules\api\v1\models\Customer as CustomerModel;
use api\modules\api\v1\models\repositories\CountryRepository;

/**
 * Interface CustomerInterface
 *
 * @package api\modules\api\v1\services
 */
interface CustomerInterface
{
    /**
     * Creates new address and binds it to passed customer model.
     *
     * @param CountryRepository $countryRepository
     * @param CustomerModel $customer
     * @param Address $address
     * @param Request $request
     * @return Address
     */
    public function addAddress(
        CountryRepository $countryRepository,
        CustomerModel $customer,
        Address $address,
        Request $request
    );

    /**
     * Returns address by ID from customer model.
     *
     * @param CustomerModel $customer
     * @param $addressId
     * @return Address
     */
    public function getAddress(CustomerModel $customer, $addressId);

    /**
     * Deletes address by ID from customer model.
     *
     * @param CustomerModel $customer
     * @param $addressId
     */
    public function deleteAddress(CustomerModel $customer, $addressId);

    /**
     * Updates address by ID on customer model.
     *
     * @param CountryRepository $countryRepository
     * @param CustomerModel $customer
     * @param Address $address
     * @param Request $request
     * @param $addressId
     * @return Address
     */
    public function updateAddress(
        CountryRepository $countryRepository,
        CustomerModel $customer,
        Address $address,
        Request $request,
        $addressId
    );

    /**
     * Creates customer and register credentials with oauth service.
     *
     * @param CustomerModel $customer
     * @param Oauth $oauthClient
     * @return mixed
     */
    public function createCustomer(CustomerModel $customer, Oauth $oauthClient, Request $request);

    /**
     * Loads data on address model reference and returns if validatio succeed.
     *
     * @param CountryRepository $countryRepository
     * @param Address $address
     * @param Request $request
     * @return bool
     */
    public function validateAddress(CountryRepository $countryRepository, Address &$address, Request $request);
}

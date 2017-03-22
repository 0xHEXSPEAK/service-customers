<?php

namespace api\modules\api\v1\controllers;

use api\modules\api\v1\models\Country;
use api\modules\api\v1\models\Customer;
use yii;
use api\modules\api\v1\models\Address;
use yii\base\Module;
use api\modules\api\v1\services\CustomerInterface;

/**
 * Class CustomerController
 *
 * @package api\modules\api\v1\controllers
 */
class CustomerController extends BaseController
{
    /**
     * @var string $modelClass
     */
    public $modelClass = 'api\modules\api\v1\models\resources\CustomerResource';

    /**
     * @var CustomerInterface $customerService
     */
    protected $customerService;

    /**
     * CustomerController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param CustomerInterface $customerService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerInterface $customerService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        parent::__construct($id, $module, $config);
    }

    public function actionCreateAddress()
    {
        $countryCode = Yii::$app->getRequest()->getBodyParam('country');
        $stateCode = Yii::$app->getRequest()->getBodyParam('state');

        $address = new Address();
        $address->load(Yii::$app->getRequest()->getBodyParams(), '');

        $contry = Country::find()->findByISO2Code($countryCode);
        $countryState = array_filter($contry->states, function($state) use ($stateCode) {
            if ($state['iso2'] == $stateCode) {
                return false;
            }
            return true;
        });

        $address->country = $contry->toArray(['name', 'iso2']);
        $address->state = $countryState[0];

        $customer = Customer::findOne('58d1872e7b7c8d000538ba73');
        $customer->addressesData[] = $address;
        $customer->save();

        return $customer;
    }
}

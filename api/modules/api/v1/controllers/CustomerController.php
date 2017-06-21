<?php

namespace api\modules\api\v1\controllers;

use api\modules\api\v1\models\Country;
use api\modules\api\v1\models\Customer;
use api\modules\api\v1\models\resources\CustomerResource;
use api\modules\api\v1\services\Customer as CustomerService;
use Oxhexspeak\OauthFilter\Models\Client;
use yii;
use api\modules\api\v1\models\Address;
use yii\base\Module;
use api\modules\api\v1\services\CustomerInterface;
use Oxhexspeak\OauthFilter\Controllers\RestController;

/**
 * Class CustomerController
 *
 * @package api\modules\api\v1\controllers
 */
class CustomerController extends RestController
{
    /**
     * @var string $modelClass
     */
    public $modelClass = 'api\modules\api\v1\models\resources\CustomerResource';

    /**
     * @var CustomerService $customerService
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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['allow'] = [
            'customer' => [
                'create-address',
                'view-address',
                'delete-address',
                'update-address',
            ],
            'client' => [
                'index',
            ],
            'any' => [
                'view',
                'update',
                'delete',
            ]
        ];
        $behaviors['access']['optional'][] = 'create';
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionView($id)
    {
        $this->isResourceOwner($id);
        return Customer::findOne($id);
    }

    public function actionCreate()
    {
        $model = new CustomerResource();

        $model->setScenario(Customer::SCENARIO_OAUTH);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        Yii::$app->getResponse()->setStatusCode(201);

        if ($model->validate()) {
            $ch = curl_init();
            // TODO: add oauth service url to config & separate this logic to service and client
            curl_setopt($ch, CURLOPT_URL,"http://172.17.0.1:8001/api/v1/o-auth/register");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER  , 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
            ));

            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query([
                    'username' => $model->getAttribute('email'),
                    'password' => $model->getAttribute('password'),
                ])
            );

            $response = curl_exec ($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $oAuthUser = json_decode(substr($response, $header_size));

            if (!curl_getinfo($ch, CURLINFO_HTTP_CODE) == 201 || !$oAuthUser->id) {
                throw new yii\web\BadRequestHttpException();
            }

            $model->setScenario(Customer::SCENARIO_CREATE);
            $model->load(Yii::$app->getRequest()->getBodyParams() + [
                '_id_oauth' => $oAuthUser->id
            ], '');
            $model->save();
        }

        return $model;
    }

    public function actionUpdate($id)
    {
        $this->isResourceOwner($id);

        if ($model = Customer::findOne($id)) {
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            $model->save();

            return $model;
        }

        throw new yii\web\NotFoundHttpException('The object with specified id not found.');
    }

    public function actionDelete($id)
    {
        $this->isResourceOwner($id);
        $model = Customer::findOne($id);

        if ($model && $model->delete()) {
            Yii::$app->getResponse()->setStatusCode(204);
        }

        throw new yii\web\NotFoundHttpException('The object with specified id not found.');
    }

    public function actionCreateAddress()
    {
        try {
            return $this->customerService->addAddress(
                Country::find(),
                Customer::findOne($this->getUserIdentity()->getId()),
                new Address(),
                Yii::$app->getRequest()
            );
        } catch (yii\base\InvalidValueException $e) {
            throw new yii\web\BadRequestHttpException($e->getMessage());
        }
    }

    public function actionViewAddress($addressId)
    {
        try {
            return $this->customerService->getAddress(
                Customer::findOne($this->getUserIdentity()->getId()),
                $addressId
            );
        } catch (yii\base\InvalidValueException $e) {
            throw new yii\web\NotFoundHttpException($e->getMessage());
        }
    }

    public function actionDeleteAddress($addressId)
    {
        try {
            $this->customerService->deleteAddress(
                Customer::findOne($this->getUserIdentity()->getId()),
                $addressId
            );
        } catch (yii\base\InvalidValueException $e) {
            throw new yii\web\BadRequestHttpException($e->getMessage());
        }
    }

    public function actionUpdateAddress($addressId)
    {
        try {
            $this->customerService->updateAddress(
                Country::find(),
                Customer::findOne($this->getUserIdentity()->getId()),
                new Address(),
                Yii::$app->getRequest(),
                $addressId
            );
        } catch (yii\base\InvalidValueException $e) {
            throw new yii\web\BadRequestHttpException($e->getMessage());
        }
    }
}

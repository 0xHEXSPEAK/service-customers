<?php

namespace api\modules\api\v1\controllers;

use yii;
use yii\base\Module;
use api\modules\api\v1\clients\Oauth;
use api\modules\api\v1\models\Country;
use api\modules\api\v1\models\resources\CustomerResource;
use api\modules\api\v1\services\Customer as CustomerService;
use api\modules\api\v1\models\Address;
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
        $behaviors['authenticator']['allow'] = [
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
        $behaviors['authenticator']['optional'][] = 'create';
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        return $actions;
    }

    public function actionCreate()
    {
        Yii::$app->getResponse()->setStatusCode(201);
        try {
            return $this->customerService->createCustomer(
                new CustomerResource(),
                new Oauth(new \GuzzleHttp\Client(), [
                    'oauthEndpoint' => env('AUTH_URL'),
                    'oauthClientId' => env('AUTH_CLIENT_ID'),
                    'oauthClientSecret' => env('AUTH_CLIENT_SECRET'),
                ]),
                Yii::$app->getRequest()
            );
        } catch (\Exception $e) {
            throw new yii\web\BadRequestHttpException('Oauth service not available or something went wrong');
        }
    }

    public function actionView($id)
    {
        $this->isResourceOwner($id);
        if ($model = CustomerResource::findOneByOauthId($id)) {
            return $model;
        }

        throw new yii\web\NotFoundHttpException('The object with specified id not found.');
    }

    public function actionUpdate($id)
    {
        $this->isResourceOwner($id);

        if ($model = CustomerResource::findOneByOauthId($id)) {
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            $model->save();

            return $model;
        }

        throw new yii\web\NotFoundHttpException('The object with specified id not found.');
    }

    public function actionDelete($id)
    {
        $this->isResourceOwner($id);
        $model = CustomerResource::findOneByOauthId($id);

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
                CustomerResource::findOneByOauthId($this->getUserIdentity()->getId()),
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
                CustomerResource::findOneByOauthId($this->getUserIdentity()->getId()),
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
                CustomerResource::findOneByOauthId($this->getUserIdentity()->getId()),
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
                CustomerResource::findOneByOauthId($this->getUserIdentity()->getId()),
                new Address(),
                Yii::$app->getRequest(),
                $addressId
            );
        } catch (yii\base\InvalidValueException $e) {
            throw new yii\web\BadRequestHttpException($e->getMessage());
        }
    }
}

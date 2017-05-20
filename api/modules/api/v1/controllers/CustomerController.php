<?php

namespace api\modules\api\v1\controllers;

use api\modules\api\v1\models\Country;
use api\modules\api\v1\models\Customer;
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

    public function actionView($id)
    {
        $this->isResourceOwner($id);
        return Customer::findOne($id);
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

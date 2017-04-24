<?php

namespace api\modules\api\v1\controllers;

use yii;
use api\modules\api\v1\models\Country;
use yii\base\Module;
use yii\base\Exception;
use yii\base\InvalidValueException;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use api\modules\api\v1\services\CountryInterface;
use Oxhexspeak\OauthFilter\Controllers\RestController;

class CountryController extends RestController
{
    /**
     * @var CountryInterface
     */
    protected $countryService;

    public function __construct($id, Module $module, CountryInterface $countryService, array $config = [])
    {
        $this->countryService = $countryService;
        parent::__construct($id, $module, $config);
    }

    public function init(){}

    public function actions()
    {
        return [];
    }

    public function actionIndex()
    {
        try {
            return $this->countryService->getList(Country::find(), Yii::$app->getRequest(), Yii::$app->getCache());
        } catch (Exception $e) {
            throw new ServerErrorHttpException();
        }
    }

    public function actionStates($iso2)
    {
        try {
            return $this->countryService->getStates(Country::find(), Yii::$app->getCache(), $iso2);
        } catch (InvalidValueException $e) {
            throw new NotFoundHttpException();
        } catch (Exception $e) {
            throw new BadRequestHttpException();
        }
    }
}

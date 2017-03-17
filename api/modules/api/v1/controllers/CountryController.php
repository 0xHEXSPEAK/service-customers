<?php

namespace api\modules\api\v1\controllers;

use yii;
use api\modules\api\v1\models\Country;
use cheatsheet\Time;

/**
 * CountryController
 *
 * @package api\modules\api\v1\controllers
 */
class CountryController extends BaseController
{
    /**
     * @var string
     */
    public $modelClass = 'api\modules\api\v1\models\Country';

    public function actions()
    {
        return [];
    }

    public function actionStates($id)
    {
        return $this->findCountry($id)->states;
    }

    public function actionIndex()
    {
        $page = Yii::$app->request->getQueryParam('page');
        return Yii::$app->cache->getOrSet('customer-countries-'.$page, function() {
            $dataProvider = new yii\data\ActiveDataProvider([
                'query' => Country::find()
            ]);
            return $dataProvider->getModels();
        }, Time::SECONDS_IN_A_MONTH);
    }

    public function findCountry($id)
    {
        $model = Country::findOne($id);
        if (!$model) {
            throw new yii\web\NotFoundHttpException("Object not found: $id");
        }
        return $model;
    }
}

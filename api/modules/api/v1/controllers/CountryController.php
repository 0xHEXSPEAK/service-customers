<?php

namespace api\modules\api\v1\controllers;

use yii;
use api\modules\api\v1\models\Country;

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

    public function actionStates($id)
    {
        return $this->findCountry($id)->states;
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

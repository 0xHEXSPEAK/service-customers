<?php

namespace api\modules\api\v1\controllers;

use api\modules\api\v1\models\State;
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

    public function actions()
    {
        return [];
    }

    public function actionCreate()
    {
        $country = new Country();
        try {

            foreach (Yii::$app->request->post('states') as $state) {
                $country->states[] = new State($state);
            }

            if ($country->load(Yii::$app->request->post(), '') && $country->validate()) {
                $country->save();
                return $country;
            }

        } catch (\Exception $e) {
            var_dump($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}

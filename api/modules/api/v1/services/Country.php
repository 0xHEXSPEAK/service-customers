<?php

namespace api\modules\api\v1\services;

use yii;
use yii\web\Request;
use yii\base\InvalidValueException;
use yii\caching\Cache;
use api\modules\api\v1\models\repositories\CountryRepository;
use cheatsheet\Time;

class Country implements CountryInterface
{
    const CACHE_NAMESPACE = 'customer-countries-';

    /**
     * @inheritdoc
     */
    public function getList(CountryRepository $countryRepository, Request $request, Cache $cache)
    {
        $page = $request->getQueryParam('page');
        return $cache->getOrSet(self::CACHE_NAMESPACE.$page, function() use ($countryRepository) {
            $dataProvider = new yii\data\ActiveDataProvider([
                'query' => $countryRepository
            ]);
            return $dataProvider->getModels();
        }, Time::SECONDS_IN_A_MONTH);
    }

    /**
     * @inheritdoc
     */
    public function getStates(CountryRepository $countryRepository, Cache $cache, $countryISO2)
    {
        return $cache->getOrSet(self::CACHE_NAMESPACE.$countryISO2,
            function () use ($countryRepository, $countryISO2) {
                $model = $countryRepository->findByISO2Code(strtoupper($countryISO2));
                if ($model) {
                    return $model->states;
                }
                throw new InvalidValueException();
            }, Time::SECONDS_IN_A_MONTH);
    }
}

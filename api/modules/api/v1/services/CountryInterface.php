<?php

namespace api\modules\api\v1\services;

use yii\web\Request;
use yii\caching\Cache;
use api\modules\api\v1\models\repositories\CountryRepository;

/**
 * Interface CustomerInterface
 *
 * @package api\modules\api\v1\services
 */
interface CountryInterface
{
    /**
     * @param CountryRepository $countryRepository
     * @param Request $request
     * @param Cache $cache
     * @return mixed
     */
    public function getList(CountryRepository $countryRepository, Request $request, Cache $cache);

    /**
     * @param CountryRepository $countryRepository
     * @param Cache $cache
     * @param $stateISO2
     * @return
     */
    public function getStates(CountryRepository $countryRepository, Cache $cache, $stateISO2);
}

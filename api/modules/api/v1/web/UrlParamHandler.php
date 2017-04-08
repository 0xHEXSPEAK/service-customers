<?php

namespace api\modules\api\v1\web;

use yii\rest\UrlRule as BaseUrlRule;

class UrlParamHandler extends BaseUrlRule
{
    /**
     * Use this method if your resource index starts at 0,
     * but you prefer to use the standard starting point as 1
     *
     * @param $param
     * @return mixed
     */
    public static function decrement($param)
    {
        return --$param;
    }
}
<?php

namespace api\modules\api\v1\web;

use yii\rest\UrlRule as BaseUrlRule;

class UrlRule extends BaseUrlRule
{
    /**
     * Array of callable items registered for additional
     * request params processing.
     *
     * @var array
     */
    public $paramHandlers = [];

    /**
     * Extended to be able to apply custom handlers for
     * each request param.
     *
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool|\yii\web\Request
     */
    public function parseRequest($manager, $request)
    {
        $request = parent::parseRequest($manager, $request);
        if ($request && is_array($request[1])) {
            array_walk($request[1], function(&$param, $index) {
                if (array_key_exists($index, $this->paramHandlers)) {
                    $param = $this->paramHandlers[$index]($param);
                }
            });
        }
        return $request;
    }
}
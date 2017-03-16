<?php

namespace api\modules\api\v1\controllers;

use yii\base\Module;
use api\modules\api\v1\services\CustomerInterface;

/**
 * Class CustomerController
 *
 * @package api\modules\api\v1\controllers
 */
class CustomerController extends BaseController
{
    /**
     * @var string $modelClass
     */
    public $modelClass = 'api\modules\api\v1\models\Customer';

    /**
     * @var CustomerInterface $customerService
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
}

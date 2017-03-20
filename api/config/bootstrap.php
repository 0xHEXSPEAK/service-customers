<?php

// Di container
\Yii::$container->set(
    'api\modules\api\v1\services\CustomerInterface',
    'api\modules\api\v1\services\Customer'
);

\Yii::$container->set(
    'api\modules\api\v1\services\CountryInterface',
    'api\modules\api\v1\services\Country'
);

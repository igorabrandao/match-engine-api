<?php

namespace api\modules\v1;

use yii\filters\Cors;

/**
 * module module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'HEAD', 'OPTIONS', 'DELETE', 'PUT'],
                'Access-Control-Allow-Credentials' => ['true'],
                'Access-Control-Expose-Headers' => [
                    'X-Pagination-Current-Page',
                    'X-Pagination-Page-Count',
                    'X-Pagination-Per-Page',
                    'X-Pagination-Total-Count',
                    'Link'
                ]
            ]
        ];

        return $behaviors;
    }
}

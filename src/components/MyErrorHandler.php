<?php

namespace modava\article\components;


class MyErrorHandler extends \yii\web\ErrorHandler
{
    public $errorView = '@modava/article/views/error/error.php';

}
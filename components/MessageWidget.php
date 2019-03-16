<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 28.11.2018
 * Time: 1:14
 */

namespace app\components;
use yii\base\Widget;
use app\models\Support;

class MessageWidget extends Widget
{
    public $model;

    public function init() {
        parent::init();
        $this->model  = new Support;
    }

    public function run() {
        return $this->render('message', [
            'model'      => $this->model,
        ]);
    }
}
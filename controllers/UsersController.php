<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 28.11.2018
 * Time: 0:09
 */

namespace app\controllers;


class UsersController extends SiteController
{
    public function actionReviews($user_id=0) {
        echo $user_id;
    }
    public function actionInfo($user_id=0) {
        echo $user_id;
    }
}
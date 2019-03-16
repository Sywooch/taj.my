<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 10.12.2018
 * Time: 16:38
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class BillingStatusName extends ActiveRecord
{
    public static function tableName() {
        return '{{cc_billing_status}}';
    }

    public function getTitle() {
        if(Yii::$app->language=='ar') {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }
}
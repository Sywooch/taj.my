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

class DialogMessage extends ActiveRecord
{
    public static function tableName() {
        return '{{cc_dialog_content}}';
    }
    
    
    public function getLimitedContent($limit) {
        if(isset($this->content)) {
            return \yii\helpers\StringHelper::truncate($this->content, $limit, ' <span class="font-gray">...</span>');
        } else {
            return '';
        }
    }

}
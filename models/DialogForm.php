<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 10.12.2018
 * Time: 22:54
 */

namespace app\models;

use Yii;
use yii\base\Model;

class DialogForm extends Model
{
    
    public $content;
    public $dialog_id;
    public $title;
    public $user_to;
    
    public function rules() {
        return [
            [['content','dialog_id'],  'required', 'message'=> \Yii::t('main', 'Can`t be blank')],
            ['title','string'],
            ['user_to','integer'],
        
        ];
    }

    public function attributeLabels()
    {
        return [
            [['content'], \Yii::t('main', '') ]
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 11.12.2018
 * Time: 12:50
 */

namespace app\models;

use Yii;
use yii\base\Model;

class ProductForm extends Model
{

    public $title;
    public $description;
    public $image;
    public $category_id;

    public function rules()
    {
        return [
            [
                ['image'], 'file',
                'skipOnEmpty' => false,
                'extensions' => 'gif, jpg, png, jpeg',
            ],
            [['title', 'category_id'],'required'],
            [['description'],'string']
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 10.12.2018
 * Time: 13:21
 */

namespace app\components;

use Yii;
use app\controllers\SiteController;
use yii\base\Widget;

class BreadcrumbWidget extends Widget
{
    public $path, $current, $data, $category, $product;

    public function init() {
        parent::init();
        if($this->path  === null) $this->path       = 'content';
        if($this->current  === null) $this->current = '';
        if($this->product=== null)          $this->product = [];
    }

    public function run() {

        if($this->path=='category') {
            $data = [
                'current' =>   $this->category->name,
                'category'  => []
            ];

            if ($this->category->parent_id != 0) {
                $category = SiteController::getParent($this->category->parent_id);
                $category_link = array_reverse($category);
                foreach ($category_link as $c) {
                    $data['category'][] = [
                        'name' => $c['name'],
                        'type' => ['products/' . $c['link']]
                    ];
                }
            }
        } elseif($this->path=='product') {
            $data = [
                'current' =>   $this->current,
                'category'  => []
            ];

            if ($this->category->parent_id != 0) {
                $category = SiteController::getParent($this->category->parent_id);
                $category_link = array_reverse($category);
                foreach ($category_link as $c) {
                    $data['category'][] = [
                        'name' => $c['name'],
                        'type' => ['products/' . $c['link']]
                    ];
                }
                $data['category'][] = [
                    'name' => $this->category->name,
                    'type' => ['products/' . $this->category->link]
                ];
            } else {
				$data['category'][] = [
					'name' => $this->category->getTitle(),
					'type' => ['products/' . $this->category->link]
				];	
			}
        } elseif($this->path=='ProductReview') {
            if ($this->category->parent_id != 0) {
                $category = SiteController::getParent($this->category->parent_id);
                $category_link = array_reverse($category);
				
				
                foreach ($category_link as $c) {
                    $data['category'][] = [
                        'name' => $c['name'],
                        'type' => ['products/' . $c['link']]
                    ];
                }
			}
			$data['category'][] = [
				'name' => $this->category->getTitle(),
				'type' => ['products/' . $this->category->link]
			];
			$data['category'][] = [
				'name' => $this->product->getTitle(),
				'type' => [
					'product/product',
					'category_link'=>$this->category->link,
					'link'=> $this->product['link']
				]
			];
			if($this->current) {
				$data['current'] =  $this->current;
			} else {
				$data['current'] = Yii::t('main', 'New Review');
			}
        }

        return $this->render('breadcrumb', [
            'current'       => $data['current'],
            'category'      => $data['category'],
        ]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 28.11.2018
 * Time: 1:14
 */

namespace app\components;
use yii\base\Widget;

class PaginationWidget extends Widget
{
    public $path, $page, $limit, $count, $firstPath, $readMore;

    public function init() {
        parent::init();
        if($this->path  === null) $this->path       = '';
        if($this->page  === null) $this->page       = 0;
        if($this->limit === null) $this->limit      = 0;
        if($this->count === null) $this->count      = 0;
        if($this->firstPath===null) $this->firstPath = $this->path;
        if($this->readMore===null) $this->readMore = 'Next';
    }

    public function run() {
        return $this->render('pagination', [
            'path'      => $this->path,
            'page'      => $this->page,
            'limit'     => $this->limit,
            'count'     => $this->count,
            'firstPath' => $this->firstPath,
            'readMore'  => $this->readMore,
        ]);
    }
}
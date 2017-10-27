<?php
namespace common\models\search;

use io\data\DataSet;
use io\helpers\Html;
use io\helpers\ArrayHelper;

use io\widgets\Toolstrip;
use common\models\NewsItem;

class NewsCategoryItemSearch extends \common\models\NewsCategory{

    public function attributes(){
        return [
            'page_size'         => \IO::translate('io', 'Page size'),
            'search_value'      => \IO::translate('io', 'Search value'),
        ];
    }

    public $search_value = '';
    public $page_size = 20;
    public $page = 1;
    public $filters = [
        [
            'className' => '\io\widgets\ToolstripList',
            'attribute' => 'page_size',
            'options' => [
                'inputOptions' => [

                ],
                'options' => [
                    'items' => [
                        20 => '20',
                        50 => '50',
                        100 => '100'
                    ]
                ]
            ]
        ],
    ];

    public static function getDataList($addEmpty = false){
        return [];
    }

    public static function search($data){

        $searchModel = new self();

        $searchModel->load($data);

        $query = NewsItem::find();
        $query->leftJoin('news_category as nc', ['nc.id' => 'news_item.news_category_id']);

        $searchModel->page_size =   isset($_GET['pageSize'])    ? $_GET['pageSize']   : $searchModel->page_size;
        $searchModel->page =        isset($_GET['page'])        ? $_GET['page']       : $searchModel->page;

        $searchModel->dataSet = new DataSet([
            'pagination' => [
                'page' => $searchModel->page,
                'pageSize' => $searchModel->page_size
            ],
            'query' => $query
        ]);
        return $searchModel;
    }
}
?>

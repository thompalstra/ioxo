<?php
namespace common\models;

use io\data\DataSet;
use io\helpers\Html;
use io\helpers\ArrayHelper;

use io\widgets\Toolstrip;

class NewsSearch extends \common\models\NewsItem{

    public function attributes(){
        return [
            'page_size'         => \IO::translate('io', 'Page size'),
            'search_value'      => \IO::translate('io', 'Search value'),
        ];
    }

    public $search_value = '';
    public $page_size = 20;
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

    public function getDataList(){
        return [];
    }

    public function console(){
        $form = new \io\widgets\Form([
            'template' => '{input}',
            'templateOptions' => [
                'rowBegin' => [],
                'label' => [],
                'input' => ['class'=> ''],
                'error' => [],
            ],
            'options' => [
                'id' => 'form-search-form',
                'class' => 'form form-default',
                'method' => 'POST'
            ]
        ]);
        $out = $form->begin();
        $out .= "<div class='row row-default col dt12 tb12 mb12 xs12'>";
        $out .= $form->field($this, 'search_value')->label(false)->iconInput('<i class="material-icons icon">search</i>', [
            'class' => 'input input-default dt12 tb12 mb12 xs12',
            'type' => 'text',
            'list' => 'auth-search',
            'placeholder' => $this->getAttributeLabel('search_value')
        ]);
        $out .= Html::datalist('auth-search', self::getDataList(), ['class' => 'data-list']);
        $out .= "</div>";
        $out .= $form->field($this, 'filters')->label(false)->widget(Toolstrip::className(), []);
        $out .= $form->end();

        return $out;
    }

    public function getName(){
        $model = $this->model;
        $model = $model::getClass();
        $add = '';
        if(strpos($this->attribute, '[]') !== false){
            $add = '[]';
        }
        $attribute = $this->attribute;

        return $model."[".$attribute."]".$add;
    }

    public static function search($data){

        $search = new self();

        $search->load($data);

        $query = NewsItem::find();

        if(!empty($search->search_value)){

        }

        $search->dataSet = new DataSet([
            'pagination' => [
                'page' => (isset($_GET['page']) ? $_GET['page'] : 1),
                'pageSize' => $search->page_size
            ],
            'query' => $query
        ]);
        return $search;
    }
}
?>

<?php
namespace common\models\search;

use io\data\DataSet;
use io\helpers\Html;
use io\helpers\ArrayHelper;

use io\widgets\Toolstrip;

class TranslateSearch extends \io\base\Translate{

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
        return ArrayHelper::map( self::find()->all(), 'id', 'source_message');
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
                'autosubmit' => '',
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

        $searchModel = new self();

        $searchModel->load($data);

        $query = self::find();

        if(!empty($authSearch->search_value)){
            $query->where([
                'LIKE' => [
                    'source_message' => "%$authSearch->search_value%"
                ],
            ]);
        }

        $query->groupBy('source_message');

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

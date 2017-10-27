<?php
namespace common\models\search;

use io\data\DataSet;
use io\helpers\Html;
use io\helpers\ArrayHelper;

use io\web\Auth;

use io\widgets\Toolstrip;

class UserSearch extends \common\models\User{

    public function attributes(){
        return [
            'page_size'         => \IO::translate('io', 'Page size'),
            'search_value'      => \IO::translate('io', 'Search value'),
            'is_enabled'        => \IO::translate('io', 'Enabled'),
        ];
    }

    public $search_value = '';
    public $is_enabled = -1;
    public $role = -1;
    public $page_size = 20;
    public $page = 1;

    public function rules(){
        return [
            [['is_enabled'], 'safe']
        ];
    }

    public static function getDataList($addEmpty = false){
        return ArrayHelper::map( self::find()->where(['=' => ['is_deleted' => 0]])->all(), 'id', 'username');
    }

    public function console(){

        $this->filters = [
            [
                'className' => '\io\widgets\ToolstripList',
                'attribute' => 'is_enabled',
                'options' => [
                    'inputOptions' => [

                    ],
                    'options' => [
                        'items' => [
                            -1 =>   "Any",
                            1 =>    "Enabled",
                            0 =>    "Disabled"
                        ]
                    ]
                ]
            ],
            [
                'className' => '\io\widgets\ToolstripList',
                'attribute' => 'role',
                'options' => [
                    'inputOptions' => [

                    ],
                    'options' => [
                        'items' => [-1=>"Any"] + Auth::getDataList()
                    ]
                ]
            ],
            [
                'className' => '\io\widgets\ToolstripList',
                'attribute' => 'page_size',
                'options' => [
                    'inputOptions' => [

                    ],
                    'options' => [
                        'items' => [1=>'1', 20 => '20', 50 => '50', 100 => '100']
                    ]
                ]
            ],
        ];

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
            ],
        ]);
        $out = $form->begin();
        $out .= "<div class='row row-default col dt12 tb12 mb12 xs12'>";
        $out .= $form->field($this, 'search_value')->label(false)->iconInput('<i class="material-icons icon">search</i>', [
            'class' => 'input input-default dt12 tb12 mb12 xs12',
            'type' => 'text',
            'list' => 'user-search'

        ]);
        $out .= Html::datalist('user-search', self::getDataList(), ['class' => 'data-list']);
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


        if($searchModel->role != -1){
            $query->leftJoin('auth_user', ['auth_user.user_id' => 'user.id']);
            $query->leftJoin('auth', ['auth.id' => 'auth_user.auth_id']);
        }



        $query->where([
            '=' => [
                'is_deleted' => 0
            ]
        ]);
        if($searchModel->is_enabled != -1){
            $query->andWhere([
                '=' => [
                    'is_enabled' => $searchModel->is_enabled
                ]
            ]);
        }
        if(!empty($searchModel->search_value)){
            $query->andWhere([
                'LIKE' => [
                    'username' => "%$searchModel->search_value%"
                ],
            ]);
        }
        if($searchModel->role != -1){
            $query->andWhere([
                '=' => [
                    'auth.id' => $searchModel->role,
                ],
            ]);
        }

        $searchModel->page_size =   isset($_GET['pageSize'])    ? $_GET['pageSize']   : $searchModel->page_size;
        $searchModel->page =        isset($_GET['page'])        ? $_GET['page']       : $searchModel->page;

        $query->groupBy('user.id');
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
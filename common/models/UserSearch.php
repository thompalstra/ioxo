<?php
namespace common\models;

use io\data\DataSet;
use io\helpers\Html;
use io\helpers\ArrayHelper;

use io\widgets\Toolstrip;

class UserSearch extends \common\models\User{

    public $search_value = '';
    public $is_enabled = -1;
    public $role = -1;
    public $page_size = 20;
    public $filters = [
        [
            'className' => '\io\widgets\ToolstripList',
            'attribute' => 'is_enabled',
            'options' => [
                'inputOptions' => [

                ],
                'options' => [
                    'items' => [-1 => 'Any', 1 => 'Enabled', 0 => 'Disabled']
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
                    'items' => [-1 => 'Any', 1 => 'Backend', 2 => 'Administrator']
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
                    'items' => [20 => '20', 50 => '50', 100 => '100']
                ]
            ]
        ],
    ];

    public function rules(){
        return [
            [['is_enabled'], 'safe']
        ];
    }

    public function getDataList(){
        return ArrayHelper::map( self::find()->where(['=' => ['is_deleted' => 0]])->all(), 'id', 'username');
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

        $userSearch = new self();

        $userSearch->load($data);

        $query = self::find();


        if($userSearch->role != -1){
            $query->leftJoin('auth_user', ['auth_user.user_id' => 'user.id']);
            $query->leftJoin('auth', ['auth.id' => 'auth_user.auth_id']);
        }



        $query->where([
            '=' => [
                'is_deleted' => 0
            ]
        ]);
        if($userSearch->is_enabled != -1){
            $query->andWhere([
                '=' => [
                    'is_enabled' => $userSearch->is_enabled
                ]
            ]);
        }
        if(!empty($userSearch->search_value)){
            $query->andWhere([
                'LIKE' => [
                    'username' => "%$userSearch->search_value%"
                ],
            ]);
        }
        if($userSearch->role != -1){
            $query->andWhere([
                '=' => [
                    'auth.id' => $userSearch->role,
                ],
            ]);
        }
        $query->groupBy('user.id');
        $userSearch->dataSet = new DataSet([
            'pagination' => [
                'page' => (isset($_GET['page']) ? $_GET['page'] : 1),
                'pageSize' => $userSearch->page_size
            ],
            'query' => $query
        ]);
        return $userSearch;
    }
}
?>

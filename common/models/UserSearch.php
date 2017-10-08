<?php
namespace common\models;

use io\data\DataSet;
use io\helpers\Html;

class UserSearch extends \io\web\User{

    public $searchValue = 'herp';
    public $is_enabled;
    public $filters = [
        'searchValue' => [
            'type' => 'textInput',
            'attribute' => 'searchValue'
        ],
        'is_enabled' => [
            'type' => 'dropdown',
            'attribute' => 'is_enabled',
            'items' => ['' => 'Enabled: <b>any</b>', 1 => 'Enabled: <b>true</b>', 0 => 'Enabled: <b>false</b>'],
            'options' => [
                'class' => 'input input-default'
            ],

        ],
    ];

    public function console(){
        $out = Html::textInput('UserSearch[searchValue]', $this->searchValue, ['class' => 'input input-default']);

        $out .= "<div class='filters'>";
        foreach($this->filters as $filter){
            $out .= self::tool($filter);
        }
        $out .= "</div>";

        return $out;
    }

    public function tool($filter){
        $type = $filter['type'];
        $options = $filter['options'];
        $attribute = $filter['attribute'];
        $options['value'] = $this->$attribute;

        switch($type){
            case 'textInput':
                $attribute = $filter['attribute'];
                $name = "UserSearch[$attribute]";
                $value = $this->$attribute;
                $options = [
                    'class' => 'input input-default'
                ];
                return Html::textInput($name, $value, $options);
            break;
            case 'dropdown':
                $attribute = $filter['attribute'];
                $name = "UserSearch[$attribute]";
                $value = $this->$attribute;
                return Html::dropdown($name, $value, $filter['items'], $filter['options']);
            break;
        }
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
        $query->where([
            '=' => [
                'is_deleted' => 0,
                'is_enabled' => 1
            ]
        ]);

        if($userSearch->searchValue){
            $query->andWhere([
                'LIKE' => [
                    'username' => "%$userSearch->searchValue%"
                ],
            ]);
        }

        $userSearch->dataSet = new DataSet([
            'pagination' => [
                'page' => (isset($_GET['page']) ? $_GET['page'] : 1),
                'pageSize' =>(isset($_GET['pageSize']) ? $_GET['pageSize'] : 1),
            ],
            'query' => $query
        ]);

        return $userSearch;
    }
}
?>

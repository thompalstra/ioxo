<?php
namespace common\models;

use io\data\DataSet;

class UserSearch extends \io\web\User{

    public $searchValue;

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
                    'name' => "%$userSearch->searchValue%"
                ],
            ]);
        }

        $userSearch->dataSet = new DataSet([
            'pagination' => [
                'page' => 1,
                'pageSize' => 1,
            ],
            'query' => $query
        ]);

        return $userSearch;
    }
}
?>

<?php
namespace backend\models\search;

use Scope;

use scope\data\ModelDataProvider;
use common\models\scope\cms\Page;

class Pages extends Page{
    public function search(){
        $query = Scope::query()->from( Page::className() );
        $query->where([
            'and',
            [ 'is_deleted' => 0 ]
        ]);

        return new ModelDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
    }
}
?>

<?php

use common\models\NewsContent;
use io\web\Html;
$url = "/documentation/$model->url";


?>


<a href="<?=$url?>">
    <div class='block-inner' style='border: 1px solid #ddd'>
        <h2 class='title'><?=$model->title?></h2>
    </div>
</a>

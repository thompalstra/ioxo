<?php

use common\models\NewsContent;
use io\web\Html;

$firstContent = $model->firstContent;


$newsCategory = $model->category;
$url = "/documentation/$newsCategory->url/$model->url";


?>


<a href="<?=$url?>">
    <div class='block-inner' style='border: 1px solid #ddd'>
        <h2 class='title'><?=$model->title?></h2>
        <?php if($firstContent){ ?>
            <<?=NewsContent::$types[$firstContent->type]?> class='content'>
                        <?=$firstContent->content?>
            </<?=NewsContent::$types[$firstContent->type]?>>
        <?php } else { ?>
            <div class='content'></div>
        <?php } ?>

    </div>
</a>

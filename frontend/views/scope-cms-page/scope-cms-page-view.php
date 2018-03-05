<?php
$this->title = Scope::$app->context->page->getTitle();
?>

<div class='wrapper'>
    <?=Scope::$app->context->page->getHTML()?>
</div>

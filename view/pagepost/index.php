<?php
namespace Anax\View;

/*
if (!$resultset) {
    return;
}*/
foreach ($resultNavbar as $page) :
    ?>
    <a href="<?= url("pagepost/linkNav") ?>/<?= $page->title ?>"><?= $page->title ?></a>
<?php endforeach;
?>


<!-- ifall post ska skrivas ut -->
<?php if ($resultPost) :
    ?>
<div>
    <?php foreach ($resultPost as $post) :
        ?>
    <a href="<?= url("pagepost/blogInd") ?>/<?= $post["id"] ?>"><h2><?= $post["title"] ?></h2></a>
    <p>publiserat: <?= htmlentities($post["published"]) ?></p>
    <p><?= $post["data"] ?></p>
    <?php endforeach;
    ?>
</div>
<?php endif; ?>

<!-- ifall page ska skrivas ut -->
<?php if ($resultPageTitle) :
    ?>
<div>
    <h1><?= $resultPageTitle ?></h1>
    <p><?= htmlentities($resultPageData) ?></p>
</div>
<?php endif; ?>

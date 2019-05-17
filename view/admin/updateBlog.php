<?php
namespace Anax\View;

?>


<form method="post">

    <label>path:</label><br>
    <input type="text" name="path" value="<?= $resultset[0]->path ?>"><br>

    <label>slug:</label><br>
    <input type="text" name="slug" value="<?= $resultset[0]->slug ?>"><br>

    <label>title:</label><br>
    <input type="text" name="title" value="<?= $resultset[0]->title ?>"><br>

    <label>data:</label><br>
    <input type="textarea" name="data" value="<?= $resultset[0]->data ?>"><br>

    <label>type:</label><br>
    <input type="text" name="type" value="<?= $resultset[0]->type ?>"><br>

    <label>filter:</label><br>
    <input type="text" name="filter" value="<?= $resultset[0]->filter ?>"><br>

    <label>published:</label><br>
    <input type="text" name="published" value="<?= $resultset[0]->published ?>"><br>

    <input type="hidden" name="id" value="<?= $resultset[0]->id ?>"><br>

    <input type="submit" name="editDB" value="Spara">
</form>

<?php
namespace Anax\View;

?>

<a href="<?= url("admin/index") ?>">uppdater/radera blogg inlägg</a>

<h1>Lägg till nytt inlägg</h1>

<form method="post">
    <label>Path:</label><br>
    <input type="text" name="path"><br>

    <label>Slug:</label><br>
    <input type="text" name="slug"><br>

    <label>Title:</label><br>
    <input type="text" name="title"><br>

    <label>Data:</label><br>
    <input type="textarea" name="data"><br>

    <label>Type:</label><br>
    <input type="text" name="type"><br>

    <label>filter:</label><br>
    <input type="text" name="filter"><br>

    <input type="submit" name="addToDB" value="Spara">
</form>

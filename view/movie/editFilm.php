<?php
namespace Anax\View;

?>


<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= $resultset[0]->title ?>"><br>

    <label>Director:</label><br>
    <input type="text" name="director" value="<?= $resultset[0]->director ?>"><br>

    <label>Length:</label><br>
    <input type="text" name="length" value="<?= $resultset[0]->length ?>"><br>

    <label>Year:</label><br>
    <input type="text" name="year" value="<?= $resultset[0]->year ?>"><br>

    <label>Plot:</label><br>
    <input type="text" name="plot" value="<?= $resultset[0]->plot ?>"><br>

    <label>Image:</label><br>
    <input type="text" name="image" value="<?= $resultset[0]->image ?>"><br>

    <label>Subtext:</label><br>
    <input type="text" name="subtext" value="<?= $resultset[0]->subtext ?>"><br>

    <label>Speech:</label><br>
    <input type="text" name="speech" value="<?= $resultset[0]->speech ?>"><br>

    <label>Quality:</label><br>
    <input type="text" name="quality" value="<?= $resultset[0]->quality ?>"><br>

    <label>Format:</label><br>
    <input type="text" name="format" value="<?= $resultset[0]->format ?>"><br>

    <input type="hidden" name="id" value="<?= $resultset[0]->id ?>"><br>

    <input type="submit" name="editDB" value="Spara">
</form>

<?php
namespace Anax\View;

?>

<a href="<?= url("movie/index") ?>">Visa alla filmer</a>
<a href="<?= url("movie/searchFilm") ?>">Sök</a>


<form method="post" action="./addFilm">
    <label>Title:</label><br>
    <input type="text" name="title"><br>

    <label>Director:</label><br>
    <input type="text" name="director"><br>

    <label>Length:</label><br>
    <input type="text" name="length"><br>

    <label>Year:</label><br>
    <input type="text" name="year"><br>

    <label>Plot:</label><br>
    <input type="text" name="plot"><br>

    <label>Image:</label><br>
    <input type="text" name="image"><br>

    <label>Subtext:</label><br>
    <input type="text" name="subtext"><br>

    <label>Speech:</label><br>
    <input type="text" name="speech"><br>

    <label>Quality:</label><br>
    <input type="text" name="quality"><br>

    <label>Format:</label><br>
    <input type="text" name="format"><br>

    <input type="submit" name="addToDB" value="Spara">
</form>

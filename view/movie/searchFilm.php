<?php
namespace Anax\View;

?>

<a href="<?= url("movie/addFilm") ?>">Lägg till ny film</a>
<a href="<?= url("movie/index") ?>">Visa alla filmer</a>


<form class="formSearch" method="post">
    <label>Sök (titel och år):</label>
    <input type="text" name="search">
    <input type="submit" name="searchDB" value="Sök">
</form>

<?php if ($resultset != null) :?>
<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php $id = -1; foreach ($resultset as $row) :
        $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="<?= url($row->image) ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
        <td><a href="<?= url("movie/editFilm/")?>/<?= $row->id ?>" name="idE" value="idE">Edit</a></td>
        <td><a href="<?= url("movie/deleteFilm/")?>/<?= $row->id ?>" value="idD">Delete</a></td>
    </tr>
    <?php endforeach;?>
</table>
<?php endif; ?>

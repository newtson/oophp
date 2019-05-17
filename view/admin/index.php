<?php
namespace Anax\View;

/*
if (!$resultset) {
    return;
}*/

?>

<a href="<?= url("admin/addBlog") ?>">Lägg till ny blogg</a>

<h1>Administratör</h1>

<table>
    <tr class="first">
        <th>id</th>
        <th>path</th>
        <th>slug</th>
        <th>title</th>
        <th>published</th>
        <th>created</th>
        <th>updated</th>
        <th>deleted</th>
    </tr>
<?php foreach ($resultset as $row) :
    ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->path ?></td>
        <td><?= $row->slug ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td><a href="<?= url("admin/updateBlog/")?>/<?= $row->id ?>" name="idE" value="idE">Update</a></td>
        <td><a href="<?= url("admin/deleteBlog/")?>/<?= $row->id ?>" value="idD">Delete</a></td>
    </tr>
<?php endforeach; ?>
</table>

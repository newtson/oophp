<?php
namespace Ame\Admin;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 */

class AdminController implements AppInjectableInterface
{

    use AppInjectableTrait;

    /**
         * This is the index method action, it handles:
         * ANY METHOD mountpoint
         * ANY METHOD mountpoint/
         * ANY METHOD mountpoint/index
         *
         * @return string
         */
    public function indexAction() : object
    {
        $title = "administratör";


        $this->app->db->connect();

        $sql = "SELECT * FROM `content`";
        $resultset = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $resultset,
        ];


        // går till view/admin/index.php
        $this->app->page->add("admin/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function addBlogActionGet() : object
    {
        $title = "add blog";

        // går till view/admin/addBlog.php
        $this->app->page->add("admin/addBlog");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function addBlogActionPost() : object
    {
        $title = "Lagt till blogg";

       // Create an object
        $request = new \Anax\Request\Request();

        if ($request->getPost("path") == "") {
            $path = null;
        } else {
            $path = $request->getPost("path");
        }
        $slug = $request->getPost("slug") ?? null;
        $title = $request->getPost("title") ?? null;
        $data = $request->getPost("data") ?? null;
        $type = $request->getPost("type") ?? null;
        $filter = $request->getPost("filter") ?? null;


        $this->app->db->connect();

        $checkSlug = new Blogg();

        // LÄGG in anrop till en metod som fixar slug
        // kontrollerar om $slug är null isåfall skapas slug av titel
        if ($slug == null) {
            // användare har inte angett sin egen slug för inlägget

            // kontrollerar ifall användare har angett titel som då kan läggas in som slug

            // anropar metoden slugify i klassen Blogg och skickar in titeln för att göras till slug
            $fSlug = $checkSlug->slugify($title);

            // kontrollerar ifall slug redan finns i databasen
            $sqlCheck = "SELECT `slug` FROM `content`";
            $existing = $this->app->db->executeFetchAll($sqlCheck);
            $resSlug = $checkSlug->checkSame($existing, $fSlug);
            if ($resSlug) {
                // slug finns sedan tidigare i databasen
                //FELHANTERING
                throw new SlugDoubleException("Slug already exists.");
            } else {
                $finalSlug = $fSlug;
            }
        } else {
            // användare har angett sin egen slug

            // kontrollerar ifall slug redan finns i databasen
            $sqlCheck = "SELECT `slug` FROM `content`";
            $existing = $this->app->db->executeFetchAll($sqlCheck);
            $resSlug = $checkSlug->checkSame($existing, $slug);
            if ($resSlug) {
                // slug finns sedan tidigare i databasen
                //FELHANTERING
                throw new SlugDoubleException("Slug already exists.");
            } else {
                // ifall användare har angett sin egen slug och den inte finns sedan tidigare i tabellen
                $finalSlug = $slug;
            }
        }


        $sql = null;
        $resultset = null;

        $sql = "INSERT INTO `content`(`path`, `slug`, `title`, `data`, `type`, `filter`) VALUES (?,?,?,?,?,?)";
        $this->app->db->execute($sql, [$path, $finalSlug, $title, $data, $type, $filter]);

       // hämtar alla filmer för att skicka vidare till index
        $sql2 = "SELECT * FROM `content`";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/admin/index.php
        $this->app->page->add("admin/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function updateBlogActionGet($id) : object
    {
        $title = "update blog";

        $this->app->db->connect();

        // gets the blog from content table that has the id that is sent in
        $sql2 = "SELECT * FROM `content` WHERE `id` = ?;";
        $resultset = $this->app->db->executeFetchAll($sql2, [$id]);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/admin/updateBlog.php
        $this->app->page->add("admin/updateBlog", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function updateBlogActionPost($id) : object
    {
        $title = "Lagt till blogg";

       // Create an object
        $request = new \Anax\Request\Request();

        // LÄGG in anrop till en metod som kontrollerar och fixar slug

        if ($request->getPost("path") == "") {
            $path = null;
        } else {
            $path = $request->getPost("path");
        }
        $slug = $request->getPost("slug") ?? null;
        $title = $request->getPost("title") ?? null;
        $data = $request->getPost("data") ?? null;
        $type = $request->getPost("type") ?? null;
        $filter = $request->getPost("filter") ?? null;


        $this->app->db->connect();
        $checkSlug = new Blogg();
        // lägger in ny slug ??
        if ($slug == "") {
            // ifall $slug variabel är tom
            $fSlug = $checkSlug->slugify($title);

            // kontrollerar ifall slug redan finns i databasen
            $sqlCheck = "SELECT `slug` FROM `content`";
            $existing = $this->app->db->executeFetchAll($sqlCheck);
            $resSlug = $checkSlug->checkSame($existing, $fSlug);
            if ($resSlug) {
                // slug finns sedan tidigare i databasen
                //FELHANTERING
                throw new SlugDoubleException("Slug already exists.");
            } else {
                $finalSlug = $fSlug;
            }
        } else {
            // ifall det finns ett värde i $slug variabeln
            // kontrollerar ifall slug redan finns i databasen
            $sqlCheck = "SELECT `slug` FROM `content`";
            $existing = $this->app->db->executeFetchAll($sqlCheck);
            $resSlug = $checkSlug->checkSame($existing, $slug);
            if ($resSlug) {
                // slug finns sedan tidigare i databasen
                //FELHANTERING
                throw new SlugDoubleException("Slug already exists.");
            } else {
                $finalSlug = $slug;
            }
        }


        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        $sql = "UPDATE `content` SET `path`= ?,`slug`= ?,`title`= ?,`data`= ?,`type`= ?,`filter`= ? WHERE `id`= ?";
        $this->app->db->execute($sql, [$path, $finalSlug, $title, $data, $type, $filter, $id]);

       // hämtar alla blogginlägg för att skicka vidare till index
        $sql2 = "SELECT * FROM `content`";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/admin/index.php
        $this->app->page->add("admin/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function deleteBlogAction($id) : object
    {
        $title = "Ta bort blogg";

        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        $sql = "UPDATE `content` SET `deleted`= ? WHERE `id` = ?";
        $this->app->db->execute($sql, [date("Y-m-d H:i:s"), $id]);

        // hämtar alla filmer för att skicka vidare till index
        $sql2 = "SELECT * FROM `content`;";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/admin/index.php
        $this->app->page->add("admin/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}

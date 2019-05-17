<?php
namespace Ame\Pagepost;

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

class PagepostController implements AppInjectableInterface
{

    use AppInjectableTrait;

    public function indexAction() : object
    {
        $title = "Hem";

        $this->app->db->connect();

        // hämtar data till meny
        $sqlN = "SELECT `path`, `slug`, `title` FROM `content` WHERE `type` = ? OR `path` = ?";
        $resultNavbar = $this->app->db->executeFetchAll($sqlN, ["page", "blogpost-1"]);

        //  hämtar data som är innehållet på sidan
        $sql = "SELECT `title`, `data`, `filter` FROM `content` WHERE `path`= ?";
        $resultPage = $this->app->db->executeFetchAll($sql, ["hem"]);


        $textF = new Mytextfilter();
        $resultPageData = $textF->parse($resultPage[0]->data, $resultPage[0]->filter);

        $resultPageTitle = $resultPage[0]->title;

        $data = [
            "resultPageData" => $resultPageData,
            "resultPageTitle" => $resultPageTitle,
            "resultNavbar" => $resultNavbar,
            "resultPost" => null,
        ];

        // går till view/pagepost/index.php
        $this->app->page->add("pagepost/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    public function linkNavAction($titleIn)
    {
        $this->app->db->connect();

        // hämtar page och första blogginlägget som är ett välkommen meddelande och lägger in i navbar
        $sqlN = "SELECT `path`, `slug`, `title` FROM `content` WHERE `type` = ? OR `path` = ?";
        $resultNavbar = $this->app->db->executeFetchAll($sqlN, ["page", "blogpost-1"]);

        if ($titleIn == "Välkommen till min blogg!") {
            // om användaren klickar på länken för blogg
            $sql = "SELECT `id`, `title`, `data`, `filter`, `published` FROM `content` WHERE `type`= ?";
            $resultP = $this->app->db->executeFetchAll($sql, ["post"]);
            $title = "Blogg";
            $resultPageData = null;
            $resultPageTitle = null;

            $textF = new Mytextfilter();
            // loopar runt array och anropar filter parse metoden
            for ($i = 0; $i < sizeof($resultP); $i++) {
                    $resultPostData = $textF->parse($resultP[$i]->data, $resultP[$i]->filter);
                    $resultPost[$i] = array("id" => $resultP[$i]->title, "title" => $resultP[$i]->title, "data" => $resultPostData, "published" => $resultP[$i]->published);
            }
        } else {
            // om användaren klickar på länk som är av type page
            // hämtar sidan
            $sql = "SELECT `title`, `data`, `filter` FROM `content` WHERE `title`= ?";
            $resultPage = $this->app->db->executeFetchAll($sql, [$titleIn]);
            $title = $resultPage[0]->title;
            $resultPost = null;
            // kör text genom det filter användaren speciferat
            $textF = new Mytextfilter();
            $resultPageData = $textF->parse($resultPage[0]->data, $resultPage[0]->filter);

            $resultPageTitle = $resultPage[0]->title;
        }

        $data = [
            "resultPageData" => $resultPageData,
            "resultPageTitle" => $resultPageTitle,
            "resultNavbar" => $resultNavbar,
            "resultPost" => $resultPost,
        ];

        // går till view/pagepost/index.php
        $this->app->page->add("pagepost/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    public function blogIndAction($idIn)
    {
        $this->app->db->connect();

        // hämtar page och första blogginlägget som är ett välkommen meddelande och lägger in i navbar
        $sqlN = "SELECT `path`, `slug`, `title` FROM `content` WHERE `type` = ? OR `path` = ?";
        $resultNavbar = $this->app->db->executeFetchAll($sqlN, ["page", "blogpost-1"]);


        // hämtar id och titel pga att av någon anledning så skickas titel istället för id in
        $sql = "SELECT `id`, `title`, `published`, `data`, `filter` FROM `content` WHERE `id` = ? OR `title` = ?";
        $resultBlog = $this->app->db->executeFetchAll($sql, [$idIn, $idIn]);

        // kör text genom det filter användaren speciferat
        $textF = new Mytextfilter();
        $resultPostData = $textF->parse($resultBlog[0]->data, $resultBlog[0]->filter);
        $resultPost[0] = array("id" => $resultBlog[0]->title, "title" => $resultBlog[0]->title, "data" => $resultPostData, "published" => $resultBlog[0]->published);

        $title = $resultBlog[0]->title;

        $data = [
            "resultPageData" => null,
            "resultPageTitle" => null,
            "resultNavbar" => $resultNavbar,
            "resultPost" => $resultPost,
        ];

        // går till view/pagepost/index.php
        $this->app->page->add("pagepost/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}

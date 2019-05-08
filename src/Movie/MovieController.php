<?php
namespace Ame\Movie;

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
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class MovieController implements AppInjectableInterface
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
        $title = "Alla filmer i databasen";

        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        $sql = "SELECT * FROM `movie`";
        $resultset = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $resultset,
        ];


        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
    * takes user to search database side
    */
    public function searchFilmAction()
    {
        $title = "Sök databas";

        $resultset = null;

        $data = [
            "resultset" => $resultset,
        ];
        // går till view/movie/searchFilm.php
        $this->app->page->add("movie/searchFilm", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
    * gets data from search form
    */
    public function searchFilmActionPost()
    {
        $title = "Resultat av sökning";
        $request = new \Anax\Request\Request();

        $searchRes = $request->getPost("search") ?? null;

        $sql = null;
        $resultset = null;

        // the entered search term can be inside of a word as well
        $searchRes2 = "%" . $searchRes . "%";

        $this->app->db->connect();

        $sql = "SELECT * FROM `movie` WHERE `year` = ? OR `title` LIKE ?";
        $resultset = $this->app->db->executeFetchAll($sql, [intval($searchRes), $searchRes2]);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/searchFilm.php
        $this->app->page->add("movie/searchFilm", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
    * takes user to add a film to database side
    */
    public function addFilmAction()
    {
        $title = "Lägg till film till databas";

        // går till view/movie/addFilm.php
        $this->app->page->add("movie/addFilm");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
    * gets users data from form in add to film side
    */
    public function addFilmActionPost()
    {
        $title = "Lägg till film till databas";

        // Create an object
        $request = new \Anax\Request\Request();

        $title = $request->getPost("title") ?? null;
        $director = $request->getPost("director") ?? null;
        $length = $request->getPost("length") ?? null;
        $year = $request->getPost("year") ?? null;
        $plot = $request->getPost("plot") ?? null;
        $image = $request->getPost("image") ?? null;
        $subtext = $request->getPost("subtext") ?? null;
        $speech = $request->getPost("speech") ?? null;
        $quality = $request->getPost("quality") ?? null;
        $format = $request->getPost("format") ?? null;

        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        $sql = "INSERT INTO `movie`(`title`, `director`, `length`, `year`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $this->app->db->execute($sql, [$title, $director, $length, $year, $plot, $image, $subtext, $speech, $quality, $format]);

        // hämtar alla filmer för att skicka vidare till index
        $sql2 = "SELECT * FROM `movie`";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
    *   when user clicks to delete a film in database
    *   @param int $id contains the id of the film to be deleted
    */
    public function deleteFilmAction($id)
    {
        $title = "Ta bort film i databas";

        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        $sql = "DELETE FROM `movie` WHERE `id` = ?";
        $this->app->db->execute($sql, [$id]);

        // hämtar alla filmer för att skicka vidare till index
        $sql2 = "SELECT * FROM `movie`;";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
    * when user clicks to edit a film
    * @param int $id contains the id of the film to be edited
    */
    public function editFilmActionGet($id)
    {
        $title = "Edit";

        $this->app->db->connect();

        // gets the film from database table that has the id that is sent in
        $sql2 = "SELECT * FROM `movie` WHERE `id` = ?;";
        $resultset = $this->app->db->executeFetchAll($sql2, [$id]);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/editFilm.php
        $this->app->page->add("movie/editFilm", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
    * gets users data from form when editing a film
    */
    public function editFilmActionPost($id)
    {
        $title = "Edit";

        // Create an object
        $request = new \Anax\Request\Request();

        $title = $request->getPost("title") ?? null;
        $director = $request->getPost("director") ?? null;
        $length = $request->getPost("length") ?? null;
        $year = $request->getPost("year") ?? null;
        $plot = $request->getPost("plot") ?? null;
        $image = $request->getPost("image") ?? null;
        $subtext = $request->getPost("subtext") ?? null;
        $speech = $request->getPost("speech") ?? null;
        $quality = $request->getPost("quality") ?? null;
        $format = $request->getPost("format") ?? null;
        $id = $request->getPost("id") ?? null;

        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        $sql = "UPDATE `movie` SET `title`= ?,`director`= ?,`length`= ?,`year`= ?,`plot`= ?,`image`= ?,`subtext`= ?,`speech`= ?,`quality`= ?,`format`= ? WHERE `id`= ?";
        $this->app->db->execute($sql, [$title, $director, $length, $year, $plot, $image, $subtext, $speech, $quality, $format, $id]);


        // gets all films from movie table and sends to index
        $sql2 = "SELECT * FROM movie;";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    /*public function indexAction() : object
    {
        $sql = null;
        $resultset = null;

        //var_dump("i index: ");
        //echo("i index: ");

        $this->app->db->connect();

        $title = "Alla filmer i databasen";
        $sql = "SELECT * FROM movie;";
        $resultset = $this->app->db->executeFetchAll($sql);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function searchDBAction()
    {
        $title = "Resultat av sökning";

        //$searchRes = $_POST["search"] ?? null;
        //var_dump("i searchDb: " + $searchRes);
        //$request = new \Anax\Request\Request();
        //var_dump($request->getPost("search"));
        # Create an object
        $request = new \Anax\Request\Request();

        $searchRes = $request->getPost("search") ?? null;

        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        //$sql = "SELECT * FROM movie WHERE year = $searchRes OR title LIKE '%'$searchRes'%';";
        //$sql = "SELECT * FROM movie WHERE year = $searchRes;";
        $sql = "SELECT * FROM `movie` WHERE `year` = ? OR `title` LIKE ?";
        $resultset = $this->app->db->executeFetchAll($sql, [$searchRes, $searchRes]);
        //$resultset = $this->app->db->executeFetch($sql);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    //public function newMovieAction() : object // GET
    public function addFilmAction()
    {
        $title = "Lägg till film till databas";

        //var_dump("i addmovi: ");
        //echo("i addmovie: ");

        /*$data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);
        // går till view/movie/addFilm.php
        $this->app->page->add("movie/addFilm");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    //public function newMovieAction() : object // POST
    public function addFilmActionPost()
    {
        $title = "Lägg till film till databas";

        # Create an object
        $request = new \Anax\Request\Request();

        $title = $request->getPost("title") ?? null;
        $director = $request->getPost("director") ?? null;
        $length = $request->getPost("length") ?? null;
        $year = $request->getPost("year") ?? null;
        $plot = $request->getPost("plot") ?? null;
        $image = $request->getPost("image") ?? null;
        $subtext = $request->getPost("subtext") ?? null;
        $speech = $request->getPost("speech") ?? null;
        $quality = $request->getPost("quality") ?? null;
        $format = $request->getPost("format") ?? null;

        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        $sql = "INSERT INTO `movie`(`title`, `director`, `length`, `year`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $this->app->db->execute($sql, [$title, $director, $length, $year, $plot, $image, $subtext, $speech, $quality, $format]);

        // hämtar alla filmer för att skicka vidare till index
        //$sql2 = "SELECT * FROM movie;";
        $sql2 = "SELECT * FROM `movie`";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function deleteFilmActionPost()
    {
        $title = "Ta bort film i databas";

        # Create an object
        $request = new \Anax\Request\Request();

        $id = $request->getPost("idD") ?? null;

        $sql = null;
        $resultset = null;

        $this->app->db->connect();
        //DELETE FROM `movie` WHERE 0
        //$sql = "INSERT INTO `movie`(`title`, `director`, `length`, `year`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        //$this->app->db->execute($sql, [$title, $director, $length, $year, $plot, $image, $subtext, $speech, $quality, $format]);

        $sql = "DELETE FROM `movie` WHERE `id` = ?";
        $this->app->db->execute($sql, [$id]);

        // hämtar alla filmer för att skicka vidare till index
        $sql2 = "SELECT * FROM `movie`;";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editFilmAction()
    {
        $title = "Edit";

        # Create an object
        $request = new \Anax\Request\Request();
        $id = $request->getPost("idE") ?? null;

        $this->app->db->connect();

        // hämtar alla filmer för att skicka vidare till index
        $sql2 = "SELECT * FROM `movie` WHERE `id` = ?;";
        $resultset = $this->app->db->executeFetchAll($sql2, [$id]);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/editFilm.php
        $this->app->page->add("movie/editFilm", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editFilmActionPost()
    {
        $title = "Edit";

        # Create an object
        $request = new \Anax\Request\Request();

        //$id = $request->getPost("id") ?? null;
        # Create an object
        $request = new \Anax\Request\Request();

        $title = $request->getPost("title") ?? null;
        $director = $request->getPost("director") ?? null;
        $length = $request->getPost("length") ?? null;
        $year = $request->getPost("year") ?? null;
        $plot = $request->getPost("plot") ?? null;
        $image = $request->getPost("image") ?? null;
        $subtext = $request->getPost("subtext") ?? null;
        $speech = $request->getPost("speech") ?? null;
        $quality = $request->getPost("quality") ?? null;
        $format = $request->getPost("format") ?? null;
        $id = $request->getPost("id") ?? null;

        $sql = null;
        $resultset = null;

        $this->app->db->connect();

        //$sql = "UPDATE `movie` SET `title`= ?,`director`= ?,`length`= ?,`year`= ?,`plot`= ?,`image`= ?,`subtext`= ?,`speech`= ?,`quality`= ?,`format`= ?)";
        //$this->app->db->execute($sql, [$title, $director, $length, $year, $plot, $image, $subtext, $speech, $quality, $format]);
        $sql = "UPDATE `movie` SET `title`= ?,`director`= ?,`length`= ?,`year`= ?,`plot`= ?,`image`= ?,`subtext`= ?,`speech`= ?,`quality`= ?,`format`= ? WHERE `id`= ?";
        $this->app->db->execute($sql, [$title, $director, $length, $year, $plot, $image, $subtext, $speech, $quality, $format, $id]);


        // hämtar alla filmer för att skicka vidare till index
        $sql2 = "SELECT * FROM movie;";
        $resultset = $this->app->db->executeFetchAll($sql2);

        $data = [
            "resultset" => $resultset,
        ];

        // går till view/movie/index.php
        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}*/
// kod från min lokala phpmyadmin
// UPDATE `movie` SET `id`=[value-1],`title`=[value-2],`director`=[value-3],`length`=[value-4],`year`=[value-5],`plot`=[value-6],`image`=[value-7],`subtext`=[value-8],`speech`=[value-9],`quality`=[value-10],`format`=[value-11] WHERE 1

// kod från min lokala phpmyadmin
//DELETE FROM `movie` WHERE 0

// kod från min lokala phpmyadmin
//SELECT * FROM `movie` WHERE 1

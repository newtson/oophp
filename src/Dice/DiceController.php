<?php
namespace Ame\Dice;

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

class DiceController implements AppInjectableInterface
{

    use AppInjectableTrait;







    /**

     * @var string $db a sample member variable that gets initialised

     */

    //private $db = "not active";







    /**

     * The initialize method is optional and will always be called before the

     * target method/action. This is a convienient method where you could

     * setup internal properties that are commonly used by several methods.

     *

     * @return void

     */

    /*public function initialize() : void
    {

        // Use to initialise member variables.

        $this->db = "active";



        // Use $this->app to access the framework services.
    }*/







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

        $session = $this->app->session;

        $title = "Spela tärningsspelet";

        $won = null;
        // hides button for computers turn
        $session->set("comp", null);

        // shows buttons for player turn
        $play = "player";
        $player = "Spelare1";
        $session->set("rolls", $session->get("rolls") ?? null);
        $rolls = $session->get("rolls");

        $session->set("tempScore", $session->get("tempScore") ?? null);

        // creates new DiceHand object
        $dice = new DiceHand();
        // adds dice object to session obj
        $session->set("obj", $dice);

        // histogram
        $histogram = new Histogram();
        $histogram->injectData($session->get("obj"), $session->get("obj")->values());

        // Gets currents score for player and computer
        $compScore = $dice->getComputerCurrentScore();
        $playScore = $dice->getPlayerCurrentScore();

        $data = [
            "cScore" => $compScore,
            "pScore" => $playScore,
            "rolls" => $rolls,
            "tempScore" => $session->get("tempScore"),
            "player" => $player,
            "won" => $won,
            "comp" =>  $session->get("comp"),
            "play" => $play,
            "histogramText" => $histogram->getAsText(),
        ];

        // går till view/dice/play.php
        $this->app->page->add("dice/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This sample method action it the handler for route:
     * GET mountpoint/create
     *
     * @return string
     */
    /*public function createActionGet() : string
    {
        // Deal with the action and return a response.
        //return __METHOD__ . ", \$db is {$this->db}";
    }*/


    public function newThrowAction()
    {
        $session = $this->app->session;
        $title = "Kastat tärning";

        // calls method to roll the dices
        $session->get("obj")->roll();
        // gets dices value
        $session->get("obj")->values();

        // histogram
        $histogram = new Histogram();
        $histogram->injectData($session->get("obj"), $session->get("obj")->values());

        $player = "Spelare1";
        $won = null;
        $session->set("comp", null);

        // gets current score for computer and player
        $compScore = $session->get("obj")->getComputerCurrentScore();
        $playScore = $session->get("obj")->getPlayerCurrentScore();


        /* check if 1 is in the rolls */
        $checkRolls = $_SESSION["obj"]->checkRoll();

        if ($checkRolls == 0) {
            /* 1 is NOT in rolls */

            /* add score to temp variable. Keeps score until player saves score
            or 1 is in roll */
            $session->set("tempScore", $session->get("tempScore") + $session->get("obj")->sum());

            // show buttons for player
            $play = "player";
        } else {
            /* remove score from temp variable to 0 */
            $session->set("tempScore", 0);
            /* remove value from session rolls */
            $session->set("rolls", null);

            // show computer turn button
            $session->set("comp", "computer");
            // hides buttons for player
            $play = null;
        }


        $data = [
            "rolls" => $session->get("obj")->values(),
            "cScore" => $compScore,
            "pScore" => $playScore,
            "tempScore" => $session->get("tempScore"),
            "player" => $player,
            "won" => $won,
            "comp" => $session->get("comp"),
            "play" => $play,
            "histogramText" => $histogram->getAsText(),
        ];

        $this->app->page->add("dice/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function saveScoreAction()
    {
        $session = $this->app->session;
        $title = "Sparat poängen";

        /* adds score to players permanent score */
        $session->get("obj")->setPlayerScore($session->get("tempScore"));

        $player = "Spelare1";
        /* sets temp score to 0 */
        $session->set("tempScore", 0);

        // gets current score for computer and player
        $compScore = $session->get("obj")->getComputerCurrentScore();
        $playScore = $session->get("obj")->getPlayerCurrentScore();

        // checks if player has reached 100
        if ($playScore >= 100) {
            $won = "Spelare1 har vunnit!!!";
            $session->set("comp", null);
            $play = null;
        } else {
            $won = null;
        }
        $rolls = null;
        $tempScore = 0;

        // show button for computer
        $session->set("comp", "computer");

        // histogram
        $histogram = new Histogram();
        $histogram->injectData($session->get("obj"), $session->get("obj")->values());

        // hides buttons for player
        $play = null;

        // sets session row that contains computers play in a row to 0
        $session->set("row", 0);

        $data = [
            "rolls" => $rolls,
            "cScore" => $compScore,
            "pScore" => $playScore,
            "tempScore" => $tempScore,
            "player" => $player,
            "won" => $won,
            "comp" =>  $session->get("comp"),
            "play" => $play,
            "histogramText" => $histogram->getAsText(),
        ];

        $this->app->page->add("dice/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function computerGameAction()
    {
        $session = $this->app->session;
        $title = "Computers turn";

        $session->get("obj")->roll();
        $rolls = $session->get("obj")->values();

        /* check if 1 is in the rolls */
        $checkRolls = $_SESSION["obj"]->checkRoll();

        if ($checkRolls == 0) {
            /* 1 is NOT in rolls */

            // checks if computer should continue to play or save its score
            /* add score to temp variable */
            $session->set("tempScore", $session->get("tempScore") + $session->get("obj")->sum());

            // continues if computers permanent score  + the temperary score is lower than players
            $check = $session->get("obj")->checkComputerContinue($session->get("tempScore"));
            // session saves nr of times computer has played in a row.
            $session->set("row", $session->get("row") + 1);

            if ($check == 0 && $session->get("row") < 4) {
                // computer is to continue playing
                // computer saves its score
                $session->set("rolls", $session->get("obj")->values());
                $player = "Datorn fortsätter spela. Klicka på knappen";
                // hides buttons for player
                $play = null;
            } else {
                // computer saves its score
                $session->set("rolls", $session->get("obj")->values());
                /* adds score to computers permanent score */
                $session->get("obj")->setComputerScore($session->get("tempScore"));
                $player = "Datorn har sparat sina poäng. Din tur";
                /* remove score from temp variable to 0 */
                $session->set("tempScore", 0);
                /* remove value from session rolls */
                $session->set("rolls", null);
                // removes button for computer turn
                $session->set("comp", null);
                // shows buttons for player
                $play = "player";

                // sets session row that contains computers play in a row to 0
                $session->set("row", 0);
            }
        } else {
            /* remove score from temp variable to 0 */
            $session->set("tempScore", 0);
            /* remove value from session rolls */
            $session->set("rolls", null);
            // removes button for computer turn
            $session->set("comp", null);
            // shows buttons for player
            $play = "player";
            $player = "Datorn fick 1. Din tur";
        }

        // gets current score for computer and player
        $compScore = $session->get("obj")->getComputerCurrentScore();
        $playScore = $session->get("obj")->getPlayerCurrentScore();

        // checks if computer score has reached 100
        if ($compScore >= 100) {
            $won = "Datorn har vunnit!!!";
            $session->set("comp", null);
            $play = null;
        } else {
            $won = null;
        }

        // histogram
        $histogram = new Histogram();
        $histogram->injectData($session->get("obj"), $session->get("obj")->values());

        $data = [
            "rolls" => $rolls,
            "cScore" => $compScore,
            "pScore" => $playScore,
            "tempScore" => $session->get("tempScore"),
            "player" => $player,
            "won" => $won,
            "comp" => $session->get("comp"),
            "play" => $play,
            "histogramText" => $histogram->getAsText(),
        ];

        $this->app->page->add("dice/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function restartGameAction()
    {
        $session = $this->app->session;
        $title = "Nytt spel";

        $won = null;
        $session->set("rolls", null);

        $session->set("tempScore", 0);

        $dice = new DiceHand();
        $session->set("obj", $dice);

        // histogram
        $histogram = new Histogram();
        $histogram->injectData($session->get("obj"), $session->get("obj")->values());

        $player = "Spelare1";

        $compScore = $dice->getComputerCurrentScore();
        $playScore = $dice->getPlayerCurrentScore();
        $session->set("comp", null);

        $play = "player";

        $data = [
            "cScore" => $compScore,
            "pScore" => $playScore,
            "rolls" => $session->get("rolls"),
            "tempScore" => $session->get("tempScore"),
            "player" => $player,
            "won" => $won,
            "comp" => $session->get("comp"),
            "play" => $play,
            "histogramText" => $histogram->getAsText(),
        ];

        $this->app->page->add("dice/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }




    /**

     * This sample method dumps the content of $app.

     * GET mountpoint/dump-app

     *

     * @return string

     */

    /*public function dumpAppActionGet() : string
    {

        // Deal with the action and return a response.

        $services = implode(", ", $this->app->getServices());

        return __METHOD__ . "<p>\$app contains: $services";
    }*/







    /**

     * Add the request method to the method name to limit what request methods

     * the handler supports.

     * GET mountpoint/info

     *

     * @return string

     */

    /*public function infoActionGet() : string
    {

        // Deal with the action and return a response.

        return __METHOD__ . ", \$db is {$this->db}";
    }*/







    /**

     * This sample method action it the handler for route:

     * GET mountpoint/create

     *

     * @return string

     */

    /*public function createActionGet() : string
    {

        // Deal with the action and return a response.

        return __METHOD__ . ", \$db is {$this->db}";
    }*/







    /**

     * This sample method action it the handler for route:

     * POST mountpoint/create

     *

     * @return string

     */

    /*public function createActionPost() : string
    {

        // Deal with the action and return a response.

        return __METHOD__ . ", \$db is {$this->db}";
    }*/







    /**

     * This sample method action takes one argument:

     * GET mountpoint/argument/<value>

     *

     * @param mixed $value

     *

     * @return string

     */

    /*public function argumentActionGet($value) : string
    {

        // Deal with the action and return a response.

        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }*/







    /**

     * This sample method action takes zero or one argument and you can use - as a separator which will then be removed:

     * GET mountpoint/defaultargument/

     * GET mountpoint/defaultargument/<value>

     * GET mountpoint/default-argument/

     * GET mountpoint/default-argument/<value>

     *

     * @param mixed $value with a default string.

     *

     * @return string

     */

    /*public function defaultArgumentActionGet($value = "default") : string
    {

        // Deal with the action and return a response.

        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }*/







    /**

     * This sample method action takes two typed arguments:

     * GET mountpoint/typed-argument/<string>/<int>

     *

     * NOTE. Its recommended to not use int as type since it will still

     * accept numbers such as 2hundred givving a PHP NOTICE. So, its better to

     * deal with type check within the action method and throuw exceptions

     * when the expected type is not met.

     *

     * @param mixed $value with a default string.

     *

     * @return string

     */

    /*public function typedArgumentActionGet(string $str, int $int) : string
    {

        // Deal with the action and return a response.

        return __METHOD__ . ", \$db is {$this->db}, got string argument '$str' and int argument '$int'.";
    }*/







    /**

     * This sample method action takes a variadic list of arguments:

     * GET mountpoint/variadic/

     * GET mountpoint/variadic/<value>

     * GET mountpoint/variadic/<value>/<value>

     * GET mountpoint/variadic/<value>/<value>/<value>

     * etc.

     *

     * @param array $value as a variadic parameter.

     *

     * @return string

     */

    /*public function variadicActionGet(...$value) : string
    {

        // Deal with the action and return a response.

        return __METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value);
    }*/







    /**

     * Adding an optional catchAll() method will catch all actions sent to the

     * router. You can then reply with an actual response or return void to

     * allow for the router to move on to next handler.

     * A catchAll() handles the following, if a specific action method is not

     * created:

     * ANY METHOD mountpoint/**

     *

     * @param array $args as a variadic parameter.

     *

     * @return mixed

     *

     * @SuppressWarnings(PHPMD.UnusedFormalParameter)

     */

    public function catchAll(...$args)
    {

        // Deal with the request and send an actual response, or not.

        //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);

        return;
    }
}

<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * starts guessing game
 */
$app->router->get("guess/init", function () use ($app) {

    $game = new Ame\Guess\Guess();
    $game->random();

    /* gets random number */
    $number = $game->number();
    $tries = $game->tries();
    $_SESSION["obj"] = $game;

    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();

    $_SESSION["doCheat"] = null;

    return $app->response->redirect("guess/play");
});

/**
 * plays the guessing game, show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    $number = $_SESSION["number"] ?? 0;
    $tries = $_SESSION["tries"] ?? 0;
    $res = $_SESSION["res"] ?? null;
    $_SESSION["res"] = null;
    $doCheat = $_SESSION["doCheat"] ?? null;

    $data = [
        "number" => $number ?? null,
        "tries" => $tries,
        "res" => $res,
        "guess" => $guess ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
    ];

    // går till view/guess/play.php
    $app->page->add("guess/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * plays the guessing game, make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game";

    $number = $_POST["number"] ?? 0;
    $guess = $_POST["guess"] ?? 0;
    $tries = $_POST["tries"] ?? 0;
    $doInit = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $res = $_SESSION["res"] ?? null;

    if ($doGuess) {
        $res = $_SESSION["obj"]->makeGuess($guess);
        $tries = $_SESSION["obj"]->tries();
        $_SESSION["res"] = $res;
    }

    $data = [
        "number" => $number,
        "tries" => $tries,
        "res" => $res,
        "guess" => $guess,
        "doCheat" => $doCheat,
    ];

    // går till view/guess/play.php
    $app->page->add("guess/play", $data);

    return $app->page->render([
         "title" => $title,
     ]);
});


/**
 * starts a new guessing game
 */
$app->router->get("guess/newGame", function () use ($app) {
    $title = "Play the game";

    $game2 = new Ame\Guess\Guess();
    $game2->random();

    /* gets random number */
    $number = $game2->number();
    $tries = $game2->tries();
    $_SESSION["obj"] = $game2;

    $_SESSION["number"] = $game2->number();
    $_SESSION["tries"] = $game2->tries();

    $_SESSION["doCheat"] = null;

    $data = [
        "number" => $number,
        "tries" => $tries,
    ];

    $app->page->add("guess/play", $data);

    return $app->response->redirect("guess/play");
});

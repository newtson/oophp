<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * starts dice game
 */
$app->router->get("dice/init", function () use ($app) {
    $title = "Spela tärningsspelet";

    $won = null;
    // hides button for computers turn
    $_SESSION["comp"] = null;
    // shows buttons for player turn
    $play = "player";
    $player = "Spelare1";
    $rolls = $_SESSION["rolls"] ?? null;
    $tempScore = $_SESSION["tempScore"] ?? null;
    $_SESSION["tempScore"] = $tempScore;

    // creates new DiceHand object
    $dice = new Ame\Dice\DiceHand();
    // adds dice object to session obj
    $_SESSION["obj"] = $dice;

    // Gets currents score for player and computer
    $compScore = $dice->getComputerCurrentScore();
    $playScore = $dice->getPlayerCurrentScore();

    $data = [
        "cScore" => $compScore,
        "pScore" => $playScore,
        "rolls" => $rolls,
        "tempScore" => $tempScore,
        "player" => $player,
        "won" => $won,
        "comp" =>  $_SESSION["comp"],
        "play" => $play,
    ];

    // går till view/dice/play.php
    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * throws dices
 */
$app->router->get("dice/newThrow", function () use ($app) {
    $title = "Kastat tärning";

    // calls method to roll the dices
    $_SESSION["obj"]->roll();
    // gets dices value
    $rolls = $_SESSION["obj"]->values();

    $player = "Spelare1";
    $won = null;
    $_SESSION["comp"] = null;

    // gets current score for computer and player
    $compScore = $_SESSION["obj"]->getComputerCurrentScore();
    $playScore = $_SESSION["obj"]->getPlayerCurrentScore();

    /* check if 1 is in the rolls */
    $checkRolls = $_SESSION["obj"]->checkRoll();

    if ($checkRolls == 0) {
        /* 1 is NOT in rolls */
        $_SESSION["rolls"] = $rolls;
        /* add score to temp variable. Keeps score until player saves score
        or 1 is in roll */
        $sum = $_SESSION["obj"]->sum();
        $_SESSION["tempScore"] = $_SESSION["tempScore"] + $sum;

        // show buttons for player
        $play = "player";
    } else {
        /* remove score from temp variable to 0 */
        $_SESSION["tempScore"] = 0;
        /* remove value from session rolls */
        $_SESSION["rolls"] = null;

        // show computer turn button
        $_SESSION["comp"] = "computer";
        // hides buttons for player
        $play = null;
    }


    $data = [
        "rolls" => $rolls,
        "cScore" => $compScore,
        "pScore" => $playScore,
        "tempScore" => $_SESSION["tempScore"],
        "player" => $player,
        "won" => $won,
        "comp" => $_SESSION["comp"],
        "play" => $play,
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * saves score
 */
$app->router->get("dice/saveScore", function () use ($app) {
    $title = "Sparat poängen";

    /* adds score to players permanent score */
    $_SESSION["obj"]->setPlayerScore($_SESSION["tempScore"]);

    $player = "Spelare1";
    /* sets temp score to 0 */
    $_SESSION["tempScore"] = 0;

    // gets current score for computer and player
    $compScore = $_SESSION["obj"]->getComputerCurrentScore();
    $playScore = $_SESSION["obj"]->getPlayerCurrentScore();

    // checks if player has reached 100
    if ($playScore >= 100) {
        $won = "Spelare1 har vunnit!!!";
        $_SESSION["comp"] = null;
        $play = null;
    } else {
        $won = null;
    }
    $rolls = null;
    $tempScore = 0;

    // show button for computer
    $_SESSION["comp"] = "computer";
    // hides buttons for player
    $play = null;

    $data = [
        "rolls" => $rolls,
        "cScore" => $compScore,
        "pScore" => $playScore,
        "tempScore" => $tempScore,
        "player" => $player,
        "won" => $won,
        "comp" =>  $_SESSION["comp"],
        "play" => $play,
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * starts computers turn
 */
$app->router->get("dice/computerGame", function () use ($app) {
    $title = "Computers turn";

    $_SESSION["obj"]->roll();
    $rolls = $_SESSION["obj"]->values();
    /* check if 1 is in the rolls */
    $checkRolls = $_SESSION["obj"]->checkRoll();

    if ($checkRolls == 0) {
        /* 1 is NOT in rolls */
        $_SESSION["rolls"] = $rolls;
        /* add score to temp variable */
        $sum = $_SESSION["obj"]->sum();
        $_SESSION["tempScore"] = $_SESSION["tempScore"] + $sum;
        /* adds score to computers permanent score */
        $_SESSION["obj"]->setComputerScore($_SESSION["tempScore"]);
        $player = "Datorn har sparat sina poäng. Din tur";
        /* remove score from temp variable to 0 */
        $_SESSION["tempScore"] = 0;
        /* remove value from session rolls */
        $_SESSION["rolls"] = null;

        // removes button for computer turn
        $_SESSION["comp"] = null;
        // shows buttons for player
        $play = "player";
    } else {
        /* remove score from temp variable to 0 */
        $_SESSION["tempScore"] = 0;
        /* remove value from session rolls */
        $_SESSION["rolls"] = null;

        // removes button for computer turn
        $_SESSION["comp"] = null;
        // shows buttons for player
        $play = "player";
        $player = "Datorn fick 1. Din tur";
    }

    // gets current score for computer and player
    $compScore = $_SESSION["obj"]->getComputerCurrentScore();
    $playScore = $_SESSION["obj"]->getPlayerCurrentScore();
    //$player = "Dator";

    // checks if computer score has reached 100
    if ($compScore >= 100) {
        $won = "Datorn har vunnit!!!";
        $_SESSION["comp"] = null;
        $play = null;
    } else {
        $won = null;
    }

    $data = [
        "rolls" => $rolls,
        "cScore" => $compScore,
        "pScore" => $playScore,
        "tempScore" => $_SESSION["tempScore"],
        "player" => $player,
        "won" => $won,
        "comp" => $_SESSION["comp"],
        "play" => $play,
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * restarts game
 */
$app->router->get("dice/restartGame", function () use ($app) {
    $title = "Nytt spel";

    $won = null;
    $_SESSION["rolls"] = null;
    $rolls = $_SESSION["rolls"];
    $_SESSION["tempScore"] = 0;
    $tempScore = $_SESSION["tempScore"];

    $dice = new Ame\Dice\DiceHand();
    $_SESSION["obj"] = $dice;

    $player = "Spelare1";

    $compScore = $dice->getComputerCurrentScore();
    $playScore = $dice->getPlayerCurrentScore();
    $_SESSION["comp"] = null;
    $play = "player";

    $data = [
        "cScore" => $compScore,
        "pScore" => $playScore,
        "rolls" => $rolls,
        "tempScore" => $tempScore,
        "player" => $player,
        "won" => $won,
        "comp" => $_SESSION["comp"],
        "play" => $play,
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

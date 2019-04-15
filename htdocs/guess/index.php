<?php

include(__DIR__ . "/src/autoload.php");
include(__DIR__ . "/src/config.php");

session_name("anei17");
session_start();

/* incoming variable */
// $number = $_POST["number"] ?? 0;
// $guess = $_POST["guess"] ?? 0;
// $tries = $_POST["tries"] ?? 0;
// $doInit = $_POST["doInit"] ?? null;
// $doGuess = $_POST["doGuess"] ?? null;
// $doCheat = $_POST["doCheat"] ?? null;

//
//
// if ($doInit || $number === 0) {
//     $object = new Guess();
//     $object->random();
//
//     /* gets random number */
//     $number = $object->number();
//     $tries = $object->tries();
//     $_SESSION["obj"] = $object;

    //var_dump($object);
// } elseif ($doGuess) {
//     $res = $_SESSION["obj"]->makeGuess($guess);
//     $tries = $_SESSION["obj"]->tries();
//     //var_dump($_SESSION["obj"]);
// }


//require __DIR__ . "/view/guessNumber.php";
include(__DIR__ . "/view/guessNumber.php");

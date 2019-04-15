<?php
namespace Ame\Guess;

?>

<h1>Play the game</h1>


<p>You have <?= $tries ?> guesses left.</p>

<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <input type="submit" name="doGuess" value="Make a guess">
    <input type="submit" name="doCheat" value="Cheat">
    <button class="restartButton2" type="button"><a class="restartButton" href="newGame">Start from beginning</a></button>
</form>

<?php if ($res) : ?>
     <p>You guessed <?= $guess ?>. <?= $res ?></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>cheat: current number is <?= $number ?></p>
<?php endif; ?>

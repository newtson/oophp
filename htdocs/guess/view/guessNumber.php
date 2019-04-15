<h1>Guess the number</h1>

<p>You have <?= $tries ?> guesses left.</p>

<form action="index.php" method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <input type="submit" name="doGuess" value="Make a guess">
    <input type="submit" name="doInit" value="Start from beginning">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<?php if ($doGuess) : ?>
     <p>You guessed <?= $guess ?>. <?= $res ?></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>cheat: current number is <?= $number ?></p>
<?php endif; ?>

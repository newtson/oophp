<?php
namespace Ame\Dice;

?>

<h1>Tärningsspel 100</h1>

<p>Målet för spelet är att vara den som först får ihop 100 poäng. En spelare kan välja att kasta tärningar hur många gånger som helst MEN om en 1 dyker upp förlorar
spelaren alla de poäng som inte sparats. När en spelare klickar på "spara poängen" knappen sparas de poäng som spelaren har fått i den omgången
och plussas på till dens sparade poäng. Spelet går då över till motståndaren.</p>

<p>Instruktioner: För att spela klicka på knappen "Kasta tärningar". När du vill sluta spela den omgången klicka på knappen "Spara poängen" och klicka
sedan på knappen "Datorn kastar tärningar". Ifall en 1 kastas tas dina poäng från den omgången bort och det blir datorns tur, klicka på knappen "Datorn kastar tärningar"
för att starta datorns omgång.</p>

<h2><?= $won ?></h2>

<p>Datorns poäng: <?= $cScore ?></p>

<p>Spelares poäng: <?= $pScore ?></p>


<h3>Spelare: <?= $player ?></h3>

<div>Tärningskast: <?php
if ($rolls != null || $rolls != 0) {
    $len = sizeof($rolls);
    for ($x = 0; $x < $len; $x++) : ?>
        <i><?= $rolls[$x] ?> </i>
    <?php endfor;
} ?></div>


<p>Poäng i potten: <?= $tempScore ?></p>


<?php if ($play) :
    ?>
<button class="throwDice" type="button"><a class="throwDice2" href="newThrow">Kasta tärningar</a></button>
<?php endif; ?>

<?php if ($play) :
    ?>
    <button class="keepScore" type="button"><a class="keepScore2" href="saveScore">Spara poängen</a></button>
<?php endif; ?>

<?php if ($comp) :
    ?>
    <button class="computerThrow" type="button"><a class="computerThrow2" href="computerGame">Datorn kastar tärningar</a></button>
<?php endif; ?>

<button class="restart" type="button"><a class="restart2" href="restartGame">Starta nytt spel</a></button>

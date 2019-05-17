<?php
//namespace Ame\Mytextfilter;

?>

<h2>Showing off BBCode</h2>


<h3>Source in bbcode.txt</h3>
<pre><?= wordwrap(htmlentities($textForBbc)) ?></pre>

<h3>Filter BBCode applied, source</h3>
<pre><?= wordwrap(htmlentities($bbcres)) ?></pre>

<h3>Filter BBCode applied, HTML (including nl2br())</h3>
<?= nl2br($bbcres) ?>


<h2>Showing off Clickable</h2>

<h3>Filter Clickable applied, source</h3>
<pre><?= wordwrap(htmlentities($linkres)) ?></pre>

<h3>Filter Clickable applied, HTML</h3>
<?= $linkres ?>


<h2>Showing off Markdown</h2>

<h3>Markdown source</h3>
<pre><?= $textForMarkdown ?></pre>

<h3>Text formatted as HTML source</h3>
<pre><?= htmlentities($markdres) ?></pre>

<h3>Text displayed as HTML</h3>
<?= $markdres ?>


<h2>Showing off nlb2r</h2>

<h3>nlb2r source</h3>
<pre><?= $textFornl ?></pre>

<h3>Text formatted as HTML source</h3>
<pre><?= htmlentities($nlres) ?></pre>

<h3>Text displayed as HTML</h3>
<?= $nlres ?>

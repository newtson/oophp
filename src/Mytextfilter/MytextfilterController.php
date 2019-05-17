<?php
namespace Ame\Mytextfilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

//use Michelf\MarkdownExtra;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 */

class MytextfilterController implements AppInjectableInterface
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
        $title = "textfilters";

        $textF = new Mytextfilter();

        // to bbcode
        //$textForBbc = file_get_contents(__DIR__ . "/../text/bbcode.txt");
        //$textForBbc = file_get_contents("/home/saxon/students/20172/anei17/www/dbwebb-kurser/oophp/me/redovisa/text/bbcode.txt");
        $textForBbc = "[b]Bold text[/b] [i]Italic text[/i] [url=http://dbwebb.se]a link to dbwebb[/url]";
        $bbcres = $textF->parse($textForBbc, "bbcode");

        // to link
        //$textForLink = file_get_contents(__DIR__ . "/../text/clickable.txt");
        //$textForLink = file_get_contents("/home/saxon/students/20172/anei17/www/dbwebb-kurser/oophp/me/redovisa/text/clickable.txt");
        $textForLink = '<p>The expression matches all <a href="http://sv.wikipedia.org/wiki/Uniform_Resource_Locator">URLs</a> that are in the text and makes them clickable, without messing up the links that are already there. </p>';
        $linkres = $textF->parse($textForLink, "link");

        // to markdown
        //$textForMarkdown = file_get_contents(__DIR__ . "/../text/sample.md");
        $textForMarkdown = file_get_contents("/home/saxon/students/20172/anei17/www/dbwebb-kurser/oophp/me/redovisa/text/sample.md");
        $markdres = $textF->parse($textForMarkdown, "markdown");

        // to nl2br
        $textFornl = "foo isn't\n bar";
        $nlres = $textF->parse($textFornl, "nl2br");

        $data = [
            "bbcres" => $bbcres,
            "linkres" => $linkres,
            "markdres" => $markdres,
            "textForBbc" => $textForBbc,
            "textForLink" => $textForLink,
            "textForMarkdown" => $textForMarkdown,
            "textFornl" => $textFornl,
            "nlres" => $nlres,
        ];

        // går till view/textfilter/index.php
        $this->app->page->add("textfilter/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}

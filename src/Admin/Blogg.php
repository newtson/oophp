<?php
namespace Ame\Admin;

/**
 *
 */
class Blogg
{
    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    public function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    /**
    *
    */
    public function checkSame($existing, $slug)
    {
        // false means slug is not in $existing. True means it is in existing arr
        $res = false;
        for ($i = 0; $i < sizeof($existing); $i++) {
            if ($existing[$i]->slug == $slug) {
                $res = true;
            }
        }

        return $res;
    }
}

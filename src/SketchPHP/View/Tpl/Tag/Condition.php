<?php

namespace Sketch\View\Tpl\Tag;

class Condition extends Tag
{
    public function __construct()
    {
        $this->elseif();
        $this->else();
        $this->if();
        $this->if2();
    }

    private function config(&$left, &$right)
    {
        $left  = str_replace('.', '->', trim($left));
        $right = str_replace('.', '->', trim($right));

        if ($left[0] != '"' && $left[0] != "'" && !is_numeric($left[0]) && $left != 'false' && $left != 'true' && $left != 'null')
            $left = "\$".$left;

        if ($right[0] != '"' && $right[0] != "'" && !is_numeric($right[0]) && $right != 'false' && $right != 'true' && $right != 'null')
            $right = "\$".$right;
    }

    private function if()
    {
        $search = "/@(\s?)+if(\s?)+([$\w\d\.\"' ]+)(\s?)+([<>!=]+)(\s?)+([\$\w\d\.\"' ]+)(\s?)+:(.*?)@(\s?)+endif/is";

        Tag::match($search, function($left, $op, $right, $content = "") {

            $this->config($left, $right);

            $res  = "<?php if ($left $op $right) { ?>";
            $res .= $content;
            $res .= "<?php } ?>";
            
            Tag::replace($res);

            $this->if();
        });
    }

    private function if2()
    {
        $search = "/@(\s?)+if(\s?)+(.*?)(\s?)+:(.*?)@(\s?)+endif/is";

        Tag::match($search, function($cond, $content) {

            $res  = "<?php if ($cond) { ?>";
            $res .= $content;
            $res .= "<?php } ?>";

            Tag::replace($res);

            $this->if2();
        });
    }

    private function else()
    {
        $search = "/@(\s?)+else(\s?)+:(.*?)/is";

        Tag::match($search, function($content = "") {

            $res  = "<?php } else { ?>";
            $res .= $content;

            Tag::replace($res);

            $this->else();
        });
    }

    private function elseif()
    {
        $search = "/@(\s?)+elif(\s?)+([\$\w\.]+)(\s?)+([<>!=]+)(\s?)+([\$\w\d\.\"' ]+)(\s?)+:(.*?)/is";

        Tag::match($search, function($left, $op, $right, $content = "") {

            $this->config($left, $right);

            $res  = "<?php } elseif ($left $op $right) { ?>";
            $res .= $content;

            Tag::replace($res);

            $this->elseif();
        });
    }
}

<?php

namespace Sketch\View\Tpl\Tag;

class Statement extends Tag
{
    public function __construct()
    {
        $search = "/{(\s?)+([\$\w]+)(\s?)+([<>!=\+\-\*\/]+)(\s?)+(.*?)(\s?)+}/is";

        Tag::match($search, function($left, $op, $right) {

            Tag::replace("<?php $$left $op $right ?>");
        });
    }
}

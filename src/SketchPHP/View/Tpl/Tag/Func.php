<?php

namespace Sketch\View\Tpl\Tag;

class Func extends Tag
{
    public function __construct()
    {
        $search = "/{(\s?)+([\w]+)(\s?)+\((.*?)\)(\s?)+}/is";

        Tag::match($search, function($func, $params) {

            Tag::replace("<?php $func($params) ?>");
        });
    }
}

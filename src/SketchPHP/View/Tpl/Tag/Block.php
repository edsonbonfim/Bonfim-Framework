<?php

namespace Sketch\View\Tpl\Tag;

class Block extends Tag
{
    public function __construct()
    {
        $this->content();
        $this->default();
    }

    private function content()
    {
        foreach (Tag::$blocks as $blockName => $blockContent) {

            $search = "/@(\s?)+block(\s?)+{$blockName}.*?@(\s?)+endblock/is";

            Tag::match($search, function() use ($blockContent) {
                Tag::replace($blockContent);
                $this->content();
            });
        }
    }

    private function default()
    {
        $search = "/@(\s?)+block(\s?)+[\w]+(.*?)@(\s?)+endblock/is";

        Tag::match($search, function($content = '') {
            Tag::replace($content);
            $this->default();
        });
    }
}

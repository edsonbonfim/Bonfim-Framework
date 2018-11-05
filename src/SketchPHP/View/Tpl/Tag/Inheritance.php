<?php

namespace Sketch\View\Tpl\Tag;

class Inheritance extends Tag
{
    public function __construct()
    {
        $this->getBlockContent();
        $this->getParentContent();
    }

    private function getBlockContent(): void
    {
        $search = "/@(\s?)+extends.*@(\s?)+block(\s?)+([\w]+)/is";

        Tag::match($search, function($blockName) {

            $search = "/@(\s?)+block(\s?)+$blockName(.*?)@(\s?)+endblock/is";

            Tag::match($search, function($content) use ($blockName) {

                if (!array_key_exists($blockName, Tag::$blocks)) {
                    Tag::$blocks[$blockName] = $content;
                }

                Tag::replace('');

                $this->getBlockContent();
            });
        });
    }

    private function getParentContent(): void
    {
        $search = "/@(\s?)+extends ([\w\.]+)/is";

        Tag::match($search, function($layoutName) {

            $layoutName = str_replace('.', '/', $layoutName);

            $content = \Sketch\View\Tpl\Content::getContent($layoutName, Tag::$config);
          
            Tag::replace($content);
            
            $this->__construct();
        });
    }
}

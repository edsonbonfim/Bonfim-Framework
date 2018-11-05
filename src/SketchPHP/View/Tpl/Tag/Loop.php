<?php

namespace Sketch\View\Tpl\Tag;

class Loop extends Tag
{
    public function __construct()
    {
        $this->for1();
        $this->for2();

        $this->repeat1();
        $this->repeat2();
    }

    private function for1()
    {
        $search = "/@(\s?)+loop(\s?)+([\w]+)(\s?)+:(\s?)+([\w\.]+)(.*?)@(\s?)+endloop/is";

        Tag::match($search, function($right, $left, $content = "") {
            
            $left = str_replace('.', '->', $left);

            $res  = "<?php foreach ($$left as $$right) { ?>";
            $res .= $content;
            $res .= "<?php } ?>";

            Tag::replace($res);

            $this->for1();
        });
    }

    private function for2()
    {
        $search = "/{(\s?)+for(\s?)+([\$\w]+)(\s?)+=>(\s?)+([\$\w]+)(\s?)+:(\s?)+([\$\w]+)(\s?)+}(.*?){(\s?)+\/for(\s?)+}/is";

        Tag::match($search, function($key, $value, $left, $content = "") {
            
            $res  = "<?php foreach ($left as $key => $value) { ?>";
            $res .= $content;
            $res .= "<?php } ?>";

            Tag::replace($res);

            $this->for2();
        });
    }

    private function repeat1(): void
    {
        $search = "/{(\s?)+repeat (\s?)+([\d]+)(\s?)+}(.*?){(\s?)+\/repeat(\s?)+}/is";

        Tag::match($search, function($times, $content) {

            $var = "v".md5(microtime());

            $replace  = "<?php for (\$$var = 0; \$$var < $times; \$$var++) { ?>";
            $replace .= $content;
            $replace .= "<?php } ?>";
            
            Tag::replace($replace);

            $this->repeat1();
        });
    }

    private function repeat2(): void
    {
        $search = "/{(\s?)+repeat (\s?)+([\d]+)(\s?)+:(\s?)+([\w]+)(\s?)+}(.*?){(\s?)+\/repeat(\s?)+}/is";

        Tag::match($search, function($times, $var, $content) {
            
            $replace  = "<?php for (\$$var = 0; \$$var < $times; \$$var++) { ?>";
            $replace .= $content;
            $replace .= "<?php } ?>";
            
            Tag::replace($replace);

            $this->repeat2();
        });
    }
}

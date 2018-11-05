<?php

namespace Sketch\View\Tpl;

/**
 * Class File
 * @package Sketch\Tpl
 */
class File
{
    /**
     * @var string
     */
    private $fname;
    /**
     * @var
     */
    private $file;

    /**
     * File constructor.
     * @param string|null $fname
     */
    public function __construct(string $fname = null)
    {
        $this->fname = $fname;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        if (file_exists($this->fname)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool|resource
     */
    public function open()
    {
        return $this->file = fopen($this->fname, 'r');
    }

    /**
     * @return bool|resource
     */
    public function create()
    {
        return $this->file = fopen($this->fname, 'w+');
    }

    /**
     * @param string $content
     */
    public function write(string $content): void
    {
        fwrite($this->file, $content);
        fseek($this->file, 0);
    }

    /**
     * @param array $data
     * @return string
     */
    public function read(array $data): string
    {
        extract($data);

        ob_start();

        include $this->fname;

        return ob_get_clean();
    }

    /**
     *
     */
    public function close(): void
    {
        fclose($this->file);
    }
}

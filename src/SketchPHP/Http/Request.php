<?php

namespace Sketch\Http;


class Request
{
    public function __set($key, $value)
    {
        $this->$key = $value;
    }

    public function validate($requests)
    {
        foreach ($requests as $key => $filters) {

            foreach ($filters as $name => $value) {

                switch ($name) {

                    case 'email':
                        $this->$key = filter_var($this->$key, FILTER_SANITIZE_EMAIL);
                        break;

                    case 'required':
                        if (!isset($this->$key) || empty($this->$key))
                        {
                            $_SESSION['sketch']['errors'] = [$value];
                            header('Location: ' . $_SERVER['REQUEST_URI']);
                            exit;
                        }
                        break;
                }
            }
        }
    }
}

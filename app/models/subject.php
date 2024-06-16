<?php

namespace models;

use core\helpers\form;
use core\model;

class subject extends model
{
    use form;

    protected string $table = 'subjects';

    public string $name;
    public string $code;
    public int $marks;

    public function __toString()
    {
        return sprintf('%s (#%d)', $this->name, $this->id);
    }
}

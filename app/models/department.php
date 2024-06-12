<?php

namespace models;

use core\helpers\form;
use core\helpers\orm;
use core\model;

class department extends model
{
    use orm, form;
    protected string $table = 'departments';

    public string $name;
    public string $faculty;

    protected function orm(): array
    {
        return [
            'students' => ['has' => 'many', 'model' => student::class]
        ];
    }

    public function __toString()
    {
        return sprintf('%s (#%d)', $this->name, $this->id);
    }
}

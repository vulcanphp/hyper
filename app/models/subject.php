<?php

namespace models;

use core\helpers\form;
use core\helpers\orm;
use core\model;

class subject extends model
{
    use form, orm;

    protected string $table = 'subjects';

    public string $name;
    public string $code;
    public int $marks;

    protected function orm(): array
    {
        return [
            'students' => ['has' => 'many-x', 'model' => student::class, 'table' => 'students_subjects'],
        ];
    }

    public function __toString()
    {
        return sprintf('%s (#%d)', $this->name, $this->id);
    }
}

<?php

namespace models;

use core\helpers\form;
use core\helpers\orm;
use core\helpers\uploader;
use core\model;

class student extends model
{
    use uploader, form, orm;

    protected string $table = 'students';

    public string $name;
    public int $age;
    public int $departments_id;
    public string $gender;
    public string|array $photo;
    public null|string $mobile = '+880';
    public null|bool $single;

    protected function uploader(): array
    {
        return [
            'name' => 'photo',
            'uploadTo' => 'student',
            'extensions' => ['png', 'jpg', 'jpeg'],
        ];
    }

    protected function form(): array
    {
        return [
            'gender' => ['type' => 'radio', 'options' => ['M' => 'Male', 'F' => 'Female', 'X' => 'Other']],
        ];
    }

    protected function orm(): array
    {
        return [
            'subjects' => ['has' => 'many-x', 'model' => subject::class, 'table' => 'students_subjects'],
            'department' => ['has' => 'one', 'model' => department::class],
        ];
    }

    public function __toString()
    {
        return sprintf('%s, age(%d) gender: %s', $this->name, $this->age, $this->gender);
    }
}

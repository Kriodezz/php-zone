<?php
/*
 * Класс загрузки изображений
 */
namespace MyProject\Services;

class Uploader
{
    protected string $formName;

    public function __construct($formName = 'name_form')
    {
        $this->formName = $formName;
    }

    public function upload($path)
    {
        if ($_FILES[$this->formName]['error'] === 0) {
            move_uploaded_file($_FILES[$this->formName]['tmp_name'], $path);
        }
    }
}

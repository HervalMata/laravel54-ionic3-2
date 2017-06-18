<?php

namespace CodeFlix\Forms;

use const false;
use Kris\LaravelFormBuilder\Form;
use const true;

class SerieForm extends Form
{
    public function buildForm()
    {
        $id = $this->getData('id');

        $rulesThumbFile = 'image|max:1024';
        $rulesThumbFile = !$id ? "required|$rulesThumbFile" : $rulesThumbFile;


        $this
            ->add('title', 'text', [
                'label' => 'Título da Série',
                'rules'=> 'required|max:255'
            ])
            ->add('description', 'textarea', [
                'label' => 'Descrição da Série',
                'rules'=> 'required|max:255'
            ])
            ->add('thumb_file', 'file', [
                'required'=> !$id ? true : false,
                'label' => 'Thumbnail',
                //'rules' => 'required|image|max:1024'
                'rules' => $rulesThumbFile
            ]);
    }
}

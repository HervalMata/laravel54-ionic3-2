<?php

namespace CodeFlix\Forms;

use const false;
use Kris\LaravelFormBuilder\Form;

class VideoUploadForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('thumb', 'file',[
                'required' => false,
                'label'=> 'Thumbnail',
                'rules' => 'image|max:2048'
            ])
            ->add('file', 'file',[
                'required' => false,
                'label'=> 'Arquivo de Vídeo',
                'rules' => 'mimetypes:video/mp4'
            ])
        ->add('duration', 'text', [
            'label' => 'Duração',
            'rules' => 'required|integer|min:1'
        ]);
    }
}

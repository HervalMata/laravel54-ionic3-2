<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
use FormBuilder;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;

class VideoRelationsController extends Controller
{
    /**
     * @var VideoRepository
     */
    private $repository;

    /**
     * VideoRelationsController constructor.
     */
    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Video $video)
    {
        $form = FormBuilder::create('CodeFlix\Forms\VideoRelationForm', [
            'method' => 'POST',
            'url' => route('admin.videos.relations.store', ['video' =>
                $video->id]),
            'model' => $video
        ]);

        return view('admin.videos.relation', compact('form'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        /** @var Form $form */
        $form = FormBuilder::create(\CodeFlix\Forms\VideoRelationForm::class);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de catetorias
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $this->repository->update($form->getFieldValues(), $id);
        //enviando um msg de sucesso
        $request->session()->flash('message', 'Atribuição do Video alterado com sucesso!');

        return redirect()->route('admin.videos.relations.create', ['video'
        => $id]);
    }
}

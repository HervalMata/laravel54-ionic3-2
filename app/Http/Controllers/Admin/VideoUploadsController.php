<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\VideoUploadForm;
use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class VideoUploadsController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var VideoRepository
     */
    private $repository;

    /**
     * VideoUploadsController constructor.
     */
    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Video $video)
    {
        $form = $this->form('CodeFlix\Forms\VideoUploadForm', [
            'method' => 'POST',
            'url' => route('admin.videos.uploads.store',
                ['video' => $video->id]),
            'model' => $video
        ]);

        return view('admin.videos.upload', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        /** @var Form $form */
        $form = \FormBuilder::create(VideoUploadForm::class);
        //$form = $this->form(\CodeFlix\Forms\VideoForm::class);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de usuários
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        if($request->file('thumb')){
            $this->repository->uploadThumb($id, $request->file('thumb'));
        }

        if($request->file('file')) {
            $this->repository->uploadFile($id, $request->file('file'));
        }

        $this->repository->update(['duration' => $request->get('duration')],
            $id);

        //enviando um msg de sucesso
        $request->session()->flash('message', 'Uploads realizados com sucesso!');

        return redirect()->route('admin.videos.uploads.create',
            ['video'=>$id]);
    }
}

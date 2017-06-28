<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
use function compact;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use function redirect;
use function view;

class VideoController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var VideoRepository
     */
    private $repository;

    /**
     * VideoController constructor.
     */
    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = $this->repository->paginate();

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form('CodeFlix\Forms\VideoForm', [
            'method' => 'POST',
            'url' => route('admin.videos.store'),
        ]);

        return view('admin.videos.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var Form $form */
        //$form = FormBuilder::create(UserForm::class);
        $form = $this->form(\CodeFlix\Forms\VideoForm::class);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de usuários
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $this->repository->create($data);
        //enviando um msg de sucesso
        $request->session()->flash('message', 'Vídeo criado com sucesso!');

        return redirect()->route('admin.videos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \CodeFlix\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeFlix\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $form = FormBuilder::create(\CodeFlix\Forms\VideoForm::class,
            [
                'url' => route('admin.videos.update',
                    ['video' => $video->id]),
                'method' => 'PUT',
                'model' => $video
            ]);

        return view('admin.videos.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Form $form */
        $form = FormBuilder::create(\CodeFlix\Forms\VideoForm::class);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de catetorias
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $this->repository->update($form->getFieldValues(), $id);
        //enviando um msg de sucesso
        $request->session()->flash('message', 'Video alterado com sucesso!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return redirect()->route('admin.videos.index');
    }

    public function fileAsset(Video $video)
    {
        return response()->download($video->file_path);
    }
}

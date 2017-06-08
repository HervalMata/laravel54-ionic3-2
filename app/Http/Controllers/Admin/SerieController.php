<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Models\Serie;
use CodeFlix\Repositories\SerieRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class SerieController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var \CodeFlix\Repositories\SerieRepository
     */
    private $repository;

    /**
     * SerieController constructor.
     * @param \CodeFlix\Repositories\SerieRepository $repository
     */
    public function __construct(SerieRepository $repository)
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
        $series = $this->repository->paginate();

        return view('admin.series.index', compact('series'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form('CodeFlix\Forms\SerieForm', [
            'method' => 'POST',
            'url' => route('admin.series.store'),
        ]);

        return view('admin.series.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var Form $form */
        //$form = FormBuilder::create(UserForm::class);
        $form = $this->form(\CodeFlix\Forms\SerieForm::class);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de usuários
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        Model::unguard();
        $data['thumb']= 'thumb.jpg';
        $this->repository->create($data);
        //enviando um msg de sucesso
        $request->session()->flash('message', 'Serie criada com sucesso!');

        return redirect()->route('admin.series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $series = $this->repository->find($id);

        return view('admin.series.show', ['serie' => $series]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeFlix\Models\Serie $series
     * @return \Illuminate\Http\Response
     */
    public function edit(Serie $series)
    {
        $form = FormBuilder::create(\CodeFlix\Forms\SerieForm::class,
            [
                'url' => route('admin.series.update',
                    ['serie' => $series->id]),
                'method' => 'PUT',
                'model' => $series
            ]);

        return view('admin.series.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Form $form */
        $form = FormBuilder::create(\CodeFlix\Forms\SerieForm::class, [
            'data' => ['id' => $id]
        ]);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de catetorias
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        //$data = array_except($form->getFieldValues(), ['role', 'password']);

        //$user->fill($data);
        //$user->save();
        $this->repository->update($form->getFieldValues(), $id);
        //enviando um msg de sucesso
        $request->session()->flash('message', 'Serie alterada com sucesso!');

        return redirect()->route('admin.series.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);
        //enviando um msg de sucesso
        $request->session()->flash('message', "Serie ID: <strong>{$id}</strong> excluída com sucesso!");
        return redirect()->route('admin.series.index');
    }
}

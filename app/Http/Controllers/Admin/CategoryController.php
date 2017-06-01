<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\CategoryForm;
use CodeFlix\Models\Category;
use CodeFlix\Repositories\CategoryRepository;
use function compact;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class CategoryController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var \CodeFlix\Repositories\CategoryRepository
     */
    private $repository;

    /**
     * CategoryController constructor.
     *
     * @param \CodeFlix\Repositories\CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
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
        $categories = $this->repository->paginate();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form('CodeFlix\Forms\CategoryForm', [
            'method' => 'POST',
            'url' => route('admin.categories.store'),
        ]);

        return view('admin.categories.create', compact('form'));
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
        $form = $this->form(CategoryForm::class);

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
        $request->session()->flash('message', 'Categoria criada com sucesso!');

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->repository->find($id);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeFlix\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $form = FormBuilder::create(CategoryForm::class, [
            'url' => route('admin.categories.update', ['category' =>
                $category->id]),
            'method' => 'PUT',
            'model' => $category
        ]);

        return view('admin.categories.edit', compact('form'));
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
        $form = FormBuilder::create(CategoryForm::class, [
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
        $request->session()->flash('message', 'Categoria alterada com sucesso!');

        return redirect()->route('admin.categories.index');
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
        $request->session()->flash('message', "Categoria ID: <strong>{$id}</strong> excluída com sucesso!");
        return redirect()->route('admin.categories.index');
    }
}

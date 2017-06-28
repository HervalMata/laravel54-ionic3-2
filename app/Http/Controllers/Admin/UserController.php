<?php

namespace CodeFlix\Http\Controllers\Admin;

use function array_except;
use CodeFlix\Forms\UserForm;
use CodeFlix\Models\User;
use CodeFlix\Repositories\UserRepository;
use function compact;
use function dd;
use FormBuilder;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Form;
use Auth;
use function redirect;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UserController constructor.
     */
    public function __construct(UserRepository $repository)
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
        $users = $this->repository->paginate();

        //dd(\Auth::user()->id);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = FormBuilder::create(UserForm::class, [
            'url' => route('admin.users.store'),
            'method' => 'POST',
        ]);

        return view('admin.users.create', compact('form'));
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
        $form = FormBuilder::create(UserForm::class);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de usuários
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        //$data['role'] = User::ROLE_ADMIN;
        //$data['password'] = User::generatePassword();
        //cria o user com o metodo create
        //User::create($data);
        $this->repository->create($data);
        //enviando um msg de sucesso
        $request->session()->flash('message', 'Usuário criado com sucesso!');

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \CodeFlix\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show')->with(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeFlix\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $form = FormBuilder::create(UserForm::class, [
            'url' => route('admin.users.update', ['user' => $user->id]),
            'method' => 'PUT',
            'model' => $user
        ]);

        return view('admin.users.edit', compact('form'));
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
        $form = FormBuilder::create(UserForm::class, [
            'data' => ['id' => $id]
        ]);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de usuários
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = array_except($form->getFieldValues(), ['role', 'password']);

        //$user->fill($data);
        //$user->save();
        $this->repository->update($data, $id);
        //enviando um msg de sucesso
        $request->session()->flash('message', 'Usuário alterado com sucesso!');

        return redirect()->route('admin.users.index');
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
        //$user->delete();
        $this->repository->delete($id);
        //enviando um msg de sucesso
        $request->session()->flash('message', "Usuário ID: <strong>{$id}</strong> excluído com sucesso!");
        return redirect()->route('admin.users.index');
    }

    /**
     * Exibir na aplicacao o form de alteracao de senha
     *
     * @return \Illuminate\Http\Response
     */
    public function showPasswordForm()
    {
        if (!Auth::check()) {
            return abort(401, 'Você não tem permissão.');
        }

        // Get the currently authenticated user...
        $user = Auth::user();

        return view('admin.users.password', ['data' => $user]);
    }

    /**
     * Acao para alterar o senha do user vindo do form
     * changePasswordForm
     * @param  \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request, $id)
    {
        /* criado um XXXRequest para desacoplar do Crontroller
        $this->validate($request,
            [
                'name' => 'required|min:3|max:255',
                'email' => "required|max:255|unique:users,email,$id",
                'password' => $request->password != null ? 'required|min:8|confirmed' : 'confirmed',
                'password_confirmation' => 'sometimes|required_with:password',
//            'password'=> [
//                //'required_with:user.old_password',
//                'min:6',
//                'confirmed',
//                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*([-+_!@#$%^&*.,;?])).+$/',
//                //'different:user.old_password'
//            ],

            ],
            [
                //'required' => ':attribute não deve ficar vazio',
                //'min' => ':attribute deve ter mais de :min caracteres',
                'numeric' => ':attribute deve ser numérico',
            ]); */

        //regras para validacao, podendo aplicar em uma classe RequestCustom
        $regras = [
            'name' => 'required|min:3|max:255',
            'email' => "required|max:255|unique:users,email,$id",
            'password' => $request->password != null ? 'required|min:6|confirmed' : 'confirmed',
            'password_confirmation' => 'sometimes|required_with:password',
        ];
        //personalizando as msg de erro na validacao
        $mensagens = [
            'numeric' => ':attribute deve ser numérico',
        ];

        // vrf user logged
        if (!Auth::check() || $id != Auth::id()) {
            return abort(401, 'Você não tem permissão.');
        }
        //localzando user, caso nao encontre gera uma exception
        $user = $this->repository->find($id);
        //vrf a validacao com base nas regras e msgs
        $v = \Validator::make($request->all(), $regras, $mensagens);
        //vrf se passou
        if ($v->passes()) {
            unset($request['password_confirmation']);

            if ($request->password == null) {
                unset($request['password']);
            } else {
                $request['password'] = bcrypt($request['password']);
            }

            $user->update($request->all());
            $request->session()->flash('message', 'Dados atualizados com sucesso!');

            return redirect()->route('admin.dashboard');
        }

        //retorna para o form com os erros e passando os old_values(withInput)
        //return redirect()->to('admin/change/password')->withErrors($v);
        return redirect()->route('admin.change.password')->withErrors($v)->withInput();

    }

}

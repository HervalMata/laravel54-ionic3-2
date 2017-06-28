<?php

namespace CodeFlix\Http\Controllers\Admin\Auth;

use CodeFlix\Forms\UserSettingsForm;
use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;

class UserSettingsController extends Controller
{
    /**
     * @var \CodeFlix\Repositories\UserRepository
     */
    private $repository;

    /**
     * UserSettingsController constructor.
     */
    public function __construct(UserRepository $repository)
    {
        //dd(UserRepository::class);
        $this->repository = $repository;
    }

    /**
     * @param \CodeFlix\Models\User $user
     * @internal param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //dd('oi');
        $form = \FormBuilder::create(UserSettingsForm::class, [
            'url' => route('admin.user_settings.update'),
            'method' => 'PUT'
        ]);

        return view('admin.auth.settings', compact('form'));
    }

    /**
     * @param Request $request
     * @internal param \CodeFlix\Models\User $user
     * @internal param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /** @var Form $form */
        $form = \FormBuilder::create(UserSettingsForm::class);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de usuários
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();

        //$user->fill($data);
        //$user->save();
        $this->repository->update($data, \Auth::user()->id);
        //enviando um msg de sucesso
        $request->session()->flash('message', 'Senha alterada com sucesso!');

        return redirect()->route('admin.user_settings.edit');

    }
}

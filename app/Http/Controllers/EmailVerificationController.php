<?php

namespace CodeFlix\Http\Controllers;

use CodeFlix\Repositories\UserRepository;
use function dd;
use Jrean\UserVerification\Traits\VerifiesUsers;
use function url;

class EmailVerificationController extends Controller
{
    use VerifiesUsers;
    /**
     * @var UserRepository
     */
    private $repository;


    /**
     * EmailVerificationController constructor.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Metodo para redirecionar apos ativacao
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterVerification()
    {
        $this->loginUser();

        //return url('/admin/dashboard');
        \Request::session()->flash('info', 'Altere sua senha!');
        return route('admin.user_settings.edit');
        //return url('/admin/change/password');
        //return url('/admin/users/settings');
    }

    protected function loginUser()
    {
        $email = \Request::get('email');
        //dd($email);
        $user = $this->repository
            ->findByField('email', $email)->first();
        \Auth::login($user);
    }
}

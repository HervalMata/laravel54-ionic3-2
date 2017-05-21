<?php

namespace CodeFlix\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFlix\Models\User;
use UserVerification;

/**
 * Class UserRepositoryEloquent
 * @package namespace CodeFlix\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Sobrescrita do create para a regra da app
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $attributes['role'] = User::ROLE_ADMIN;
        $attributes['password'] = User::generatePassword();
        $model = parent::create($attributes);
        //vai guardar gerar um token que vai ficar no verificationToken
        //por meio deste token vai ser identificado o user que logo depois
        //sera validado a conta do user
        UserVerification::generate($model);
        //enviar o email com o token gerado
        UserVerification::send($model, 'Sua conta foi gerada');

        return $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

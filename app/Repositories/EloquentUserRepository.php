<?php

namespace App\Repositories;

use AB\OAuthTokenValidator\Contracts\UserRepositoryContract;
use AmineAbri\BaseRepository\Exceptions\ModelNotCreatedException;
use AmineAbri\BaseRepository\Repositories\BaseRepository;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class EloquentUserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * EloquentUserRepository constructor.
     *
     * @param UserModel $userModel
     */
    public function __construct(UserModel $userModel)
    {
        parent::__construct($userModel);

        $this->userModel    = $userModel;
    }

    /**
     * Create a new record.
     *
     * @param array $data
     *
     * @throws ModelNotCreatedException
     *
     * @return UserModel
     */
    public function create(array $data): Model
    {
        $userModel              = $this->model->newInstance();
        $userModel->uuid        = $data['uuid'] ?? Uuid::uuid5(Uuid::NAMESPACE_DNS, Str::random(64))->toString();
        $userModel->username    = $data['username'];
        $success                = $userModel->save();

        if (!$success) {
            throw new ModelNotCreatedException('ModelNotCreatedException', 500);
        }

        return $userModel;
    }

    /**
     * Update the user data.
     *
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model, array $data): Model
    {
        return $model;
    }

    /**
     * Create a new record ONLY if it doesn't already exist (based on the uuid)
     *
     * @param array $data
     *
     * @throws InvalidArgumentException
     *
     * @return Model
     */
    public function createIfNotExists(array $data): Model
    {
        Assert::keyExists($data, 'uuid');

        return $this->model->firstOrCreate(['uuid' => $data['uuid']]);
    }
}

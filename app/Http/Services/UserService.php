<?php

namespace App\Http\Services;

use App\Exceptions\UserUpdatePasswordException;
use App\Http\Repositories\User\UserRepository;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Exceptions\UserUpdateException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService
{
    private AuthService $authService;
    private UserRepository $userRepository;

    public function __construct(AuthService $authService, UserRepository $userRepository)
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }

    public function getUsers(array $data): array
    {
        $users = $this->userRepository->index($data);

        return [
            'data' => UserResource::collection($users),
            'links' => $this->getTransformedLinkData($users),
            'meta' => $this->getTransformedMetaData($users)
        ];
    }

    public function getUserForEmail(string $email): User | null
    {
        return $this->userRepository->getUserForEmail($email);
    }

    public function create(array $data): array
    {
        /** @var User $user */
        $user = $this->userRepository->create($data);

        $authData = $this->authService->login($user);

        event(new Registered($user));

        return [
            'data'    => $authData,
            'message' => __('notifications.email confirmation link')
        ];
    }

    /**
     * @param array $data
     * @return User
     */
    public function createWithoutLogin(array $data): User
    {
        /** @var User $user */
        $user = $this->userRepository->create($data);

        return $user;
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @throws UserUpdateException
     */
    public function update(array $data, User $user): UserResource
    {
        if ($this->userRepository->update($data, $user)) {
            return new UserResource($user);
        }

        throw new UserUpdateException();
    }

    public function destroy(User $user): UserResource
    {
        $this->userRepository->delete($user);

        return new UserResource($user);
    }

    public function socialUserData(array $data): array
    {
        $socialUser = $this->authService->getSocialUserData($data);

        /** @var User | null $user */
        $user = $this->getUserForEmail($socialUser['email']);

        if (empty($user)) {

            $data = [
                'name' => $socialUser['name'],
                'email' => $socialUser['email']
            ];

            $user =  $this->createWithoutLogin($data);
        }

        return $this->authService->login($user);
    }

    /**
     * @throws UserUpdateException
     */
    public function avatar(File | UploadedFile $file, User $user): UserResource
    {
        $fileName = Str::uuid() . '.' . $file->extension();
        $avatarPath = $user->avatarPath ? $user->avatarPath : '';

        if (Storage::fileExists($avatarPath)) {
            Storage::delete($avatarPath);
        }

        $path = Storage::putFileAs('avatar', $file, $fileName, 'public');

        return $this->update(['avatarPath' => $path], $user);
    }

    public function destroyAvatar(User $user): UserResource
    {
        if (Storage::fileExists($user->avatarPath)) {
            Storage::delete($user->avatarPath);
        }

        return $this->update(['avatarPath' => null], $user);
    }

    /**
     * @throws UserUpdateException
     * @throws UserUpdatePasswordException
     */
    public function password(array $data, User $user): void
    {
        if ($user->password === Hash::make($data['oldPassword'])) {
            throw new UserUpdatePasswordException();
        }

        $this->update(['password' => $data['password']], $user);
    }

    private function getTransformedLinkData(LengthAwarePaginator $data): array
    {
        return [
            'path'         => $data->getOptions()['path'],
            'firstPageUrl' => $data->url(1),
            'lastPageUrl'  => $data->url($data->lastPage()),
            'nextPageUrl'  => $data->nextPageUrl(),
            'prevPageUrl'  => $data->previousPageUrl()
        ];
    }

    private function getTransformedMetaData(LengthAwarePaginator $data): array
    {
        return [
            'currentPage'  => $data->currentPage(),
            'from'         => $data->firstItem(),
            'lastPage'     => $data->lastPage(),
            'perPage'      => $data->perPage(),
            'to'           => $data->lastItem(),
            'total'        => $data->total(),
            'count'        => $data->count(),
        ];
    }
}

<?php

namespace App\Presentation\Http\Controllers;

use App\Application\DTOs\UserDTO;
use App\Application\UseCases\Users\DeleteUser;
use App\Application\UseCases\Users\RegisterUser;
use App\Application\UseCases\Users\UpdateUser;
use App\Presentation\Models\User;
use App\Presentation\Requests\UserStoreRequest;
use App\Presentation\Requests\UserUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly RegisterUser $registerUser,
        private readonly UpdateUser $updateUser,
        private readonly DeleteUser $deleteUser,
    ) {}

    public function index(Request $request)
    {
        return responder()->success(User::all())->respond();
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        // $this->authorize('admin', User::class);

        $userDTO = new UserDTO(
            $request->name,
            $request->email,
            $request->password,
        );

        $registeredUser = $this->registerUser->execute($userDTO);

        return responder()->success($registeredUser)->respond();
    }

    public function update(int $id, UserUpdateRequest $request)
    {
        $updatedUser = $this->updateUser->execute($id, $request->validated());

        return responder()->success($updatedUser)->respond();
    }

    public function destroy(int $id)
    {
        // $this->authorize('destroy', $user);
        $this->deleteUser->execute($id);

        return responder()->success()->respond();
    }   
}

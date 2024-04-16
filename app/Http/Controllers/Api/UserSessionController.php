<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use App\Repositories\UserSessionDetailRepository;
use App\Repositories\UserSessionRepository;
use Illuminate\Support\Facades\DB;

class UserSessionController extends BaseApiController
{
    public function __construct(
        protected UserSessionRepository $userSessionRepository,
        protected UserSessionDetailRepository $userSessionDetailRepository
    )
    {
    }

    /**
     * Show all users with condition (optional)
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $condition = $request->all();
        $users = $this->userRepository->getByCondition($condition);
        $result = UserResource::collection($users);

        return $this->sendPaginationResponse($users, $result);
    }
}

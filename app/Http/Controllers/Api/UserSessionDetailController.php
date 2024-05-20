<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserSessionDetail\CreateUserSessionDetailRequest;
use App\Http\Resources\UserSessionDetail\UserSessionDetailResource;
use App\Repositories\UserSessionDetailRepository;
use App\Repositories\UserSessionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserSessionDetailController extends BaseApiController
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

    /**
     * Store a session detail
     *
     * @param  CreateUserSessionDetailRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upsert(CreateUserSessionDetailRequest $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            // Get data valid from request
            $data = $request->validated();
            $currentUser = auth()->user();
            $now = Carbon::now()->format('Y-m-d');
            // $userSessionDetail = UserSessionDetail::where('user_id', $currentUser->id)->where('date', $now)->first();
            $userSessionDetail = $this->userSessionDetailRepository->findByCondition([
                'user_id' => $currentUser->id,
                'date' => $now
            ])->first();

            if($userSessionDetail && $userSessionDetail->get_check_in && isset($data['get_check_in']) && $data['get_check_in']) {
                return $this->sendError("You have checked in!", 422, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if($userSessionDetail && $userSessionDetail->get_check_out && isset($data['get_check_out']) && $data['get_check_out']) {
                return $this->sendError("You have checked out!", 422, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $data = array_merge($data, [
                'user_id' => $currentUser->id,
                'date' => $now
            ]);

            $userSessionDetail = $this->userSessionDetailRepository->upsertUserSessionDetail($data, $userSessionDetail);
            $this->userSessionRepository->upsertUserSession($data, $userSessionDetail);
            if(!$userSessionDetail) {
                return $this->sendError("Error when create user session!", 500, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            DB::commit();
            $result = UserSessionDetailResource::make($userSessionDetail);
            return $this->sendResponse($result);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendExceptionError($e);
        }
    }
}

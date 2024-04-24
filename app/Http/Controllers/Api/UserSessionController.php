<?php

namespace App\Http\Controllers\Api;

use App\Exports\ExportUserSession;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\UserSession\UserSessionResource;
use Illuminate\Http\Request;
use App\Repositories\UserSessionDetailRepository;
use App\Repositories\UserSessionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class UserSessionController extends BaseApiController
{
    public function __construct(
        protected UserSessionRepository $userSessionRepository,
        protected UserSessionDetailRepository $userSessionDetailRepository
    )
    {
    }

    /**
     * Show all session with condition (optional)
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $condition = $request->all();
        $condition = array_merge($condition, [
            'sort' => 'user_id',
            'sortType' => 1
        ]);
        $currentDateTime = Carbon::now();
        $currentMonth = $currentDateTime->month;
        $currentYear = $currentDateTime->year;
        if(!isset($condition['month'])) {
            $condition['month'] = $currentMonth;
        }

        if(!isset($condition['year'])) {
            $condition['year'] = $currentYear;
        }

        $userSession = $this->userSessionRepository->getByCondition($condition);
        $result = UserSessionResource::collection($userSession);

        return $this->sendPaginationResponse($userSession, $result);
    }

    public function export(Request $request)
    {
        $condition = $request->all();

        $userSession = $this->userSessionRepository->getByCondition($condition);
        $result = UserSessionResource::collection($userSession);
        $export = new ExportUserSession($result);
        return $export->download('userSession.xlsx');
    }
}

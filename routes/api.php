<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\ModelController;
use App\Http\Controllers\Api\UserSessionController;
use App\Http\Controllers\Api\UserSessionDetailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum', 'acl'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/updateProfile', [ProfileController::class, 'updateProfile'])->name('update_profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('list');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
        // Route::delete('/forceDelete/{id}', [UserController::class, 'forceDelete'])->name('force_delete');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('show');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/exportUser', [UserController::class, 'exportUser'])->name('export');
        Route::get('/get-all', [UserController::class, 'getAll'])->name('getall')->withoutMiddleware(['acl']);
        Route::post('/regist-face', [UserController::class, 'registerFace'])->name('register_face')->withoutMiddleware(['acl']);
        Route::get('/regist-face-status', [UserController::class, 'getUserFaceRegisterStatus'])->name('register_face_status')->withoutMiddleware(['acl']);
    });
    Route::prefix('/event')->name('event.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('list');
        Route::get('/type', [EventController::class, 'typeEvent'])->name('getType')->withoutMiddleware(['acl']);
        Route::post('/store', [EventController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [EventController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('delete');
    });

    Route::prefix('/role')->name('role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('list');
        Route::get('/list', [RoleController::class, 'getList'])->name('listRole')->withoutMiddleware(['acl']);
        Route::post('/create-role', [RoleController::class, 'create'])->name('create');
        Route::get('/get-detail-role/{id}', [RoleController::class, 'getDetailRole'])->name('detail');
        Route::put('/update-role/{id}', [RoleController::class, 'update'])->name('update');
        Route::delete('/delete-role/{id}', [RoleController::class, 'delete'])->name('delete');
        Route::get('/listRoute', [RoleController::class, 'listRoute'])->name('get_list');
        Route::put('/changePermission/{id}', [RoleController::class, 'changePermission'])->name('change_permission');
    });

    Route::prefix('/team')->name('team.')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('list');
        Route::post('/create-new-team', [TeamController::class, 'createNewTeam'])->name('create');
        Route::get('/get-list-sub/{id}', [TeamController::class, 'getListSubTeam'])->name('listSub');
        Route::put('/update-team/{id}', [TeamController::class, 'updateTeam'])->name('update');
        Route::get('/get-detail-team/{id}', [TeamController::class, 'getDetailTeam'])->name('getDetail');
        Route::get('/get-list-user-of-team/{id}', [TeamController::class, 'getListUserOfTeam'])->name('getListUser');
        Route::post('/add-member/{id}', [TeamController::class, 'addMember'])->name('addMember');
        Route::delete('/remove-member/{id}', [TeamController::class, 'delete'])->name('removeMember');
        Route::delete('/delete-team/{id}', [TeamController::class, 'deleteTeam'])->name('delete');
        Route::get('/all-list-sub-team', [TeamController::class, 'allListSubTeam'])->name('getAllListSub');
        Route::get('/all-list-main-team', [TeamController::class, 'getAllMainTeam'])->name('getAllMainTeam');

    });
    Route::prefix('/attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('list');
        Route::post('/store', [AttendanceController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [AttendanceController::class, 'delete'])->name('delete');
        Route::get('/show/{id}', [AttendanceController::class, 'show'])->name('show');
        Route::put('/update/{id}', [AttendanceController::class, 'update'])->name('update');
        Route::put('/accept/{id}', [AttendanceController::class, 'review'])->name('accept');
        Route::put('/reject/{id}', [AttendanceController::class, 'review'])->name('reject');
        Route::get('/export', [AttendanceController::class, 'export'])->name('export');
        // Route::post('/importAttendance', [AttendanceController::class, 'importAttendance'])->name('importAttendance');
        // Route::get('/get-importAttendance', [AttendanceController::class, 'statisticalFileImport'])->name('statisticalFileImport');
        // Route::get('/export-templateImportAttendance', [AttendanceController::class, 'exportTemplate'])->name('exportTemplate');
    });

    Route::prefix('session')->name('session.')->group(function() {
        Route::post('/upsert', [UserSessionDetailController::class, 'upsert'])->name('upsert')->withoutMiddleware(['acl']);
        Route::get('/', [UserSessionController::class, 'index'])->name('list');
        Route::get('/export', [UserSessionController::class, 'export'])->name('export');
    });

    Route::prefix('model')->name('model.')->group(function() {
        Route::post('/upsert', [ModelController::class, 'upLoadModel'])->name('upsert')->withoutMiddleware(['acl','auth:sanctum']);
        Route::get('/file', [ModelController::class, 'getModel'])->name('getModel')->withoutMiddleware(['acl','auth:sanctum']);
        Route::get('/model.weights.bin', [ModelController::class, 'getModelWeight'])->name('getWeights')->withoutMiddleware(['acl','auth:sanctum']);
    });
});



<?php

namespace App\Jobs;

use App\Models\ImportUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ImportUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $rowsValidateSuccess;
    private $id;
    private $success_amount_db;
    private $success_time;
    private $countTests;
    private $import_users;

    /**
     * Create a new job instance.
     */
    public function __construct($rowsValidateSuccess, $id, $success_amount_db, $import_users)
    {
        $this->rowsValidateSuccess = $rowsValidateSuccess;
        $this->id = $id;
        $this->success_amount_db = $success_amount_db;
        $this->import_users = $import_users;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $success_time = 0;
        try {
            foreach ($this->rowsValidateSuccess as $row) {
                if ($row['dob'] != null) {
                    $dob = Carbon::createFromFormat('d/m/Y', $row['dob'])->format('Y-m-d');
                }
                $dob = null;
                $newUser = User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => $row['password'],
                    'address' => $row['address'],
                    'phone_number' => $row['phone_number'],
                    'dob' => $dob,
                    'details' => $row['details'],
                    'gender' => $row['gender'],
                    'role_id' => $row['role_id'],
                    'status' => $row['status'],
                    'created_by_id' => 1
                ]);
                if ($newUser) {
                ++$success_time;
                ImportUser::find($this->id)->update(['success_amount' => $success_time]);
                }
            }

            ImportUser::find($this->id)->update(['status' => 1]);
        }

        catch (Exception $e) {
            if($e){
                $messageError[]=$e->getMessage();
            }
            Log::channel('import_user')->info('exception' . json_encode($e->getMessage()));
        }
    }
}

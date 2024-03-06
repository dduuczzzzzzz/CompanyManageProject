<?php

namespace App\Imports;

use App\Jobs\ImportUserJob;
use App\Models\User;
use Carbon\Carbon;
use App\Models\ImportUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToCollection, WithHeadingRow , SkipsEmptyRows, WithValidation ,  SkipsOnFailure
{
    use Importable, SkipsFailures, SkipsErrors;

    /**
    * @param Collection $rows
    *
    * @return void
    */
    public function collection(Collection $rows)
    {
        if(count($rows)==0){
            ImportUser::find(session()->get('import_id'))->update(['status' => 1]);
        }
        $success_amount_db=ImportUser::find(session()->get('import_id'))->first()->success_amount;
        $import_users=ImportUser::find(session()->get('import_id'))->refresh();
        ImportUserJob::dispatch($rows, session()->get('import_id'),  $success_amount_db, $import_users)->delay(now()->addSeconds(0));
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string',
            '*.email' => 'required|string|email:rfc,dns|unique:users,email',
            '*.password' => 'required|min:6',
            '*address' => 'nullable',
            '*phone_number' => 'nullable|regex:/(0)[0-9]{9}/',
            '*dob' => 'nullable|before:today',
            '*details' => 'nullable',
            '*.gender' => 'required|in:1,2,3',
            '*.role_id' => 'required|in:1',
            '*.status' => 'required|in:0,1',
        ];
    }

}

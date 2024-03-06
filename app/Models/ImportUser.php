<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportUser extends Model
{
    use HasFactory;
    protected $table="imported_users";
    protected $primaryKey='id';
    protected $fillable=[
        'created_by_id',
        'file_name',
        'status',
        'success_amount',
        'fail_amount',
        'error',
        'total'
    ];
}

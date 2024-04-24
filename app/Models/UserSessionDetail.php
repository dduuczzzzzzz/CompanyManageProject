<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserSessionDetail extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

   protected $table = 'user_session_detail';

    protected $fillable = [
        'user_id',
        'date',
        'late',
        'leave_soon',
        'get_check_in',
        'get_check_out'
    ];

    public array $sortable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}

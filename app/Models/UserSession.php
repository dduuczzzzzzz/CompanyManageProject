<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserSession extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

   protected $table = 'user_session';

    protected $fillable = [
        'user_id',
        'month',
        'year',
        'late_count',
        'leave_soon_count',
    ];

    protected array $sortable = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

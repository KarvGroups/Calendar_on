<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'id_user',
        'user',
        'id_services',
        'id_prestadores',
        'start_time',
        'end_time',
    ];
}

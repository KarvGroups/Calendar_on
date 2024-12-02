<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'contribuinte',
        'id_prestadores',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id_prestadores', 'id');
    }
}

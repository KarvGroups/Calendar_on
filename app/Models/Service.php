<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = "services";

    protected $fillable = [
        'title',
        'price',
        'time',
        'status',
        'id_categorias',
        'id_empresa',
        'id_user',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_categorias');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categorias";

    protected $fillable = [
        'id',
        'title',
        'id_user',
        'id_services',
        'id_empresa',
        'status',
        'order',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'id_categorias');
    }
}

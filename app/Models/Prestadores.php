<?php

namespace App\Models\Prestadores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestadores extends Model
{
    use HasFactory;

    protected $table = "prestadores";

    protected $fillable = [
        'name',
        'email',
        'endereco',
        'contacto',
        'especializacao',
        'contribuinte',
        'imagem',
        'data_criacao',
        'create_at',
        'update_at'
    ];
}

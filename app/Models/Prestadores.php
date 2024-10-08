<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestadores extends Model
{
    use HasFactory;

    protected $table = "prestadores";

    protected $fillable = [
        'nome',
        'email',
        'endereco',
        'contacto',
        'especializacao',
        'contribuinte',
        'qtd_usuarios',
        'status',
        'imagem',
        'data_criacao',
        'create_at',
        'update_at'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id_prestadores', 'id');
    }
}

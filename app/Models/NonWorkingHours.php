<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonWorkingHours extends Model
{
    use HasFactory;

    // Nome correto da tabela
    protected $table = 'non_working_hours';

    // Colunas que podem ser preenchidas em massa
    protected $fillable = [
        'user_id',
        'date',
        'time',
    ];

    /**
     * Relacionamento: Horários não trabalhados pertencem a um usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

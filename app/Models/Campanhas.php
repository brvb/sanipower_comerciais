<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campanhas extends Model
{

    use HasFactory;

    protected $connection = 'campanha';
    protected $table="campanhas";

    protected $fillable = [
        'id',
        'bostamp',
        'numero',
        'titulo',
        'link',
        'dh_inicio',
        'dh_fim',
        'capa',
        'ficheiro',
        'created_at',
        'updated_at',
        'ativa',
        'destaque',
        'ordem',
        'capa_pdf'
    ];
}

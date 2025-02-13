<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anexos extends Model
{

    use HasFactory;

    protected $table="anexos-ocorrencias";

    protected $fillable = [
        'ID',
        'idOcorrencia',
        'anexo',
        'id_user'
    ];
}

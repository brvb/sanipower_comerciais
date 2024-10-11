<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoEmail extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'emails', 'local_funcionamento'];
}

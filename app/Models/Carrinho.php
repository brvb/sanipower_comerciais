<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    use HasFactory;

    protected $table="carrinho_compras";

    protected $fillable = [
        'id_encomenda',
        'id_proposta',
        'id_cliente',
        'id_user',
        'referencia',
        'designacao',
        'pvp',
        'discount',
        'discount2',
        'inkit',
        'qtd',
        'image_ref',
        'model',
        'iva',
        'iva2',
        'price',
    ];
}

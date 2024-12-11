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
        'id_visita',
        'referencia',
        'designacao',
        'pvp',
        'discount',
        'discount2',
        'inkit',
        'in_campanhas',
        'qtd',
        'image_ref',
        'model',
        'iva',
        'iva2',
        'price',
        'proposta_info',
        'awarded',
        'origin_id'
    ];
}

<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdutosDB extends Model
{

    use HasFactory;

    protected $connection = 'campanha';
    protected $table="temp_produtos";

    protected $fillable = [
        'ststamp',
        'ref',
        'design',
        'familia',
        'faminome',
        'stock',
        'epv1',
        'iva1incl',
        'unidade',
        'tabiva',
        'imagem',
        'bloqueado',
        'tipodesc',
        'Categoria_No',
        'SubFamilia_No',
        'Subfamilia',
        'Produto',
        'Medida',
        'obs',
        'marca',
        'qtd_caixa',
        'dh',
        'processado',
        'nome_produto',
        'desc_medida',
        'link',
        'StockGlobal',
        'StockPv',
        'StockBr',
        'StockFg',
        'StockVc',
        'StockAm',
        'StockTf',
        'StockPt',
        'StockVs',
        'StockVng',
        'StockVnf',
        'StockClr',
        'U_cxpeq',
        'U_cxgra',
        'U_palete',
        'seo_tags',
        'seo_descricao',
        'inativo'
    ];
}

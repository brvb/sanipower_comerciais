<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;


class FinanceiroController extends Controller
{
    private ?object $clientesRepository = NULL;
    public function __construct(ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
    }
    
    public function index()
    {
        return view('financeiro.index');
    }


    public function showDetailFinanceiro($idFinanceiro)
    {
            $financeiro = Session::get('Financeiro');
            // dd($financeiro);
            return view('financeiro.details',["financeiro" => $financeiro]);

       
    }


}

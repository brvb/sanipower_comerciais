<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;


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

    public function GerarPdfFinanceiro()
    {
        // Obtendo os dados financeiros
        $FinanceiroArray = $this->clientesRepository->getFinanceiroCliente(99999, 1, '');
        
        $financeiro = collect($FinanceiroArray["object"])->groupBy('customer_name');

        $pdf = PDF::loadView('pdf.pdfMapaDividas', ["financeiroAgrupado" => $financeiro]);

        return $pdf->stream('pdfMapaDividas.pdf'); // Retorna diretamente para o navegador
    }


}

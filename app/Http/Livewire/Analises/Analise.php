<?php

namespace App\Http\Livewire\Analises;

use Livewire\Component;
use App\Models\TiposVisitas;
use App\Models\VisitasAgendadas;
use App\Interfaces\VisitasInterface;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use App\Models\User;
use App\Models\DashboardPreference;
use App\Models\Campanhas;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;


class Analise extends Component
{
    public $table;

    use WithPagination;

    public $page = 1;
    private ?object $clientesRepository = NULL;

    public $DateIniAnalise;
    public $DateEndAnalise;

    public $analysisClientes;
    public $analysisAnualClientes;

    public $dataInicio;
    public $dataFim;

    public $clientes;

    public function boot(ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
    }

    public function mount()
    {
        $id = Auth::user()->id_phc;

        $this->analysisAnualClientes = $this->clientesRepository->getListagemAnaliseAnual($id, 0);

        $this->dataFim = '12-04-2025';

        $this->dataInicio = '01-03-2025';

        Session::put('clientes', $this->carregarClientes());

        Session::put('analysisClientes', $this->carregarFamilias());
    }

    public function carregarClientes()
    {
        $dataInicio = $_GET['dataInicio'] ?? now()->subDays(30)->format('d-m-Y');
        $dataFim = $_GET['dataFim'] ?? now()->format('d-m-Y');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/analytics/sales_by_customer?Start_date='.$dataInicio.'&End_date='.$dataFim.'&Salesman_number='.Auth::user()->id_phc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        
        curl_close($curl);
        
        $response_decoded = json_decode($response);
        
        return $response_decoded;
    }

    public function carregarFamilias()
    {
        $id = Auth::user()->id_phc;

        $this->DateIniAnalise = $_GET['DateIniAnalise'] ?? now()->subDays(30)->format('Y-m-d');
        $this->DateEndAnalise = $_GET['DateEndAnalise'] ?? now()->format('Y-m-d');

        // dd($this->DateIniAnalise, $this->DateEndAnalise);

        $this->analysisClientes = $this->clientesRepository->getListagemAnaliseFamily($this->DateIniAnalise, $this->DateEndAnalise, 0, $id);
        
        return $this->analysisClientes;
    }

    public function render()
    {
        if(!isset($this->analysisAnualClientes))
        {
            $id = Auth::user()->id_phc;

            $this->analysisAnualClientes = $this->clientesRepository->getListagemAnaliseAnual($id, 0);
        }

        $this->analysisClientes = session('analysisClientes');

        if(isset($this->analysisClientes['success']))
        {
            if($this->analysisClientes['success'] == false)
            {
                $this->analysisClientes = null;
            }
        }

        return view('livewire.Analise.analise', ["analisesCliente" => $this->analysisClientes, "vendasAnuais" =>$this->analysisAnualClientes, "clientes" =>$this->clientes ]);

    }
}

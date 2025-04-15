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

        $this->DateIniAnalise = Session::get('DateIniAnalise') ?? now()->startOfMonth()->format('Y-m-d');
        $this->DateEndAnalise = Session::get('DateEndAnalise') ?? now()->format('Y-m-d');

        $this->analysisClientes = $this->clientesRepository->getListagemAnaliseFamily($this->DateIniAnalise, $this->DateEndAnalise, 0, $id);
        $this->analysisAnualClientes = $this->clientesRepository->getListagemAnaliseAnual($id, 0);

        // Valores iniciais (últimos 30 dias)
        // $this->dataFim = now()->format('d-m-Y');
        $this->dataFim = '12-04-2025';
        // $this->dataInicio = now()->subDays(30)->format('d-m-Y');
        $this->dataInicio = '01-03-2025';


        Session::put('clientes', $this->carregarClientes());
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

    public function AlterDateIniAnalise($date)
    {
        // dd('AQUI');
        $this->DateIniAnalise = $date;
        Session::put('DateIniAnalise', $this->DateIniAnalise);

        // return redirect()->route('Analise');
        $this->emit('refreshPage');
    }

    public function AlterDateEndAnalise($date)
    {
        // dd('AQUI2');
        $this->DateEndAnalise = $date;
        Session::put('DateEndAnalise', $this->DateEndAnalise);

        // return redirect()->route('Analise');
        $this->emit('refreshPage');
    }

    public function render()
    {
        if(!isset($this->analysisClientes))
        {
            $id = Auth::user()->id_phc;

            $this->DateIniAnalise = Session::get('DateIniAnalise') ?? now()->startOfMonth()->format('Y-m-d');
            $this->DateEndAnalise = Session::get('DateEndAnalise') ?? now()->format('Y-m-d');

            $this->analysisClientes = $this->clientesRepository->getListagemAnaliseFamily($this->DateIniAnalise, $this->DateEndAnalise, 0, $id);
        }

        if(!isset($this->analysisAnualClientes))
        {
            $id = Auth::user()->id_phc;

            $this->analysisAnualClientes = $this->clientesRepository->getListagemAnaliseAnual($id, 0);
        }
        
        return view('livewire.Analise.analise', ["analisesCliente" =>$this->analysisClientes, "vendasAnuais" =>$this->analysisAnualClientes, "clientes" =>$this->clientes ]);

    }
}

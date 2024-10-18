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



class Analise extends Component
{
    public $table;

    use WithPagination;

    public $page = 1; // Propriedade para a paginação do Livewire


    public function mount()
    {
        $id = Auth::user()->id;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/analytics/pending?Salesman_number=59',
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
        // dd(env('SANIPOWER_URL_DIGITAL').'/api/analytics/pending?Salesman_number=59');

        $response = curl_exec($curl);

        curl_close($curl);

        $response_decoded = json_decode($response);
        $this->table = $response_decoded;
        // dd($response_decoded);
    }


    public function render()
    {
         
         return view('livewire.Analise.analise', ['tabela' => $this->table]);
    }
}

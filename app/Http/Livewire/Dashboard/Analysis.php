<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\TiposVisitas;
use App\Models\VisitasAgendadas;
use App\Interfaces\VisitasInterface;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use App\Models\User;
use App\Models\DashboardPreference;
use Illuminate\Support\Facades\Route;


class Analysis extends Component
{
    public $show90dias = '';
    public $showObjFat = '';
    public $showTop500 = '';
    public $showTop1000 = '';
    public $showObjMargin = '';
    public $showSlsCus = '';

    public $objective = '';
    public $sales = '';

    public $Month;
    public $Year;


    
    public $INICIO;

    public function mount()
    {    
        $preferences = DashboardPreference::where('Id_user', Auth::id())->first();
            if ($preferences) {
                $this->show90dias = $preferences->days90 == 1 ? true : false;
                $this->showObjFat = $preferences->ObjFat == 1 ? true : false;
                $this->showTop500 = $preferences->Top500 == 1 ? true : false;
                $this->showTop1000 = $preferences->Top1000 == 1 ? true : false;
                $this->showObjMargin = $preferences->ObjMargin == 1 ? true : false;
                $this->showSlsCus = $preferences->SlsPerCus == 1 ? true : false;
            }

            $this->Month = now()->month; 
            $this->Year = now()->year;   



            $this->updateDateproductSalesChart();
            $this->updateDateObjetivoFat1();
            $this->updateDateObjetivoFat2();
            $this->updateDateObjetivoFat3();
            $this->updateDateObjetivoFat4();
            // $this->updateDateObjetivoFat5();


            $this->INICIO = 1;            

    }   

    public function FlushAll()
        {
            // dd('AQUI');

            $this->updateDateproductSalesChart();
            $this->updateDateObjetivoFat1();
            $this->updateDateObjetivoFat2();
            $this->updateDateObjetivoFat3();
            $this->updateDateObjetivoFat4();

            $this->dispatchBrowserEvent('callJavascriptFunction', [
                'function' => 'productSalesChart',
                'objectiveProd' => session('objectiveProd') ?? 0,
                'salesProd' => session('salesProd') ?? 0,
                'objectiveOBJ1' => session('objectiveOBJ1') ?? 0,
                'salesOBJ1' => session('salesOBJ1') ?? 0,
                'objectiveOBJ2' => session('objectiveOBJ2') ?? 0,
                'salesOBJ2' => session('salesOBJ2') ?? 0,
                'objectiveOBJ3' => session('objectiveOBJ3') ?? 0,
                'salesOBJ3' => session('salesOBJ3') ?? 0,
                'objectiveOBJ4' => session('objectiveOBJ4') ?? 0,
                'salesOBJ4' => session('salesOBJ4') ?? 0      
            ]);

        }
    

    public function updateDateproductSalesChart()
    {
        // dd('Mês:'.$this->Month.'Ano:'.$this->Year);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/analytics/90days_objectives?Salesman_number='.Auth::user()->id_phc.'&year='.$this->Year.'&month='.$this->Month,
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
        // dd($response_decoded);
        if(isset($response_decoded->Message))
        {
            session(['objectiveProd' => 0]);
            session(['salesProd' => 0]);
            return;
        }
        session(['objectiveProd' => $response_decoded->objective]);
        session(['salesProd' => $response_decoded->sales]);
        return;

    }

    public function updateDateObjetivoFat1()
    {
        // dd('Mês:'.$this->Month.'Ano:'.$this->Year);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/analytics/objectives?Salesman_number='.Auth::user()->id_phc.'&year='.$this->Year.'&month='.$this->Month,
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
        // dd( env('SANIPOWER_URL_DIGITAL').'/api/analytics/objectives?Salesman_number=59&year='.$this->Year.'&month='.$this->Month, $response_decoded);
        if(isset($response_decoded->Message))
        {
            session(['objectiveOBJ1' => 0]);
            session(['salesOBJ1' => 0]);
            return;
        }

        session(['objectiveOBJ1' => $response_decoded->objective]);
        session(['salesOBJ1' => $response_decoded->sales]);
        return;
    }

    public function updateDateObjetivoFat2()
    {
        // dd('Mês:'.$this->Month.'Ano:'.$this->Year);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/analytics/top500_objectives?Salesman_number='.Auth::user()->id_phc.'&year='.$this->Year.'&month='.$this->Month,
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
        // dd( env('SANIPOWER_URL_DIGITAL').'/api/analytics/objectives?Salesman_number=59&year='.$this->Year.'&month='.$this->Month, $response_decoded);
        if(isset($response_decoded->Message))
        {
            session(['objectiveOBJ2' => 0]);
            session(['salesOBJ2' => 0]);
            return;
        }

        session(['objectiveOBJ2' => $response_decoded->objective]);
        session(['salesOBJ2' => $response_decoded->sales]);
        return;
    }

    public function updateDateObjetivoFat3()
    {
        // dd('Mês:'.$this->Month.'Ano:'.$this->Year);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/analytics/margin_objectives?Salesman_number='.Auth::user()->id_phc.'&year='.$this->Year.'&month='.$this->Month,
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
        // dd( env('SANIPOWER_URL_DIGITAL').'/api/analytics/objectives?Salesman_number=59&year='.$this->Year.'&month='.$this->Month, $response_decoded);
        if(isset($response_decoded->Message))
        {
            session(['objectiveOBJ3' => 0]);
            session(['salesOBJ3' => 0]);
            return;
        }

        session(['objectiveOBJ3' => $response_decoded->objective]);
        session(['salesOBJ3' => $response_decoded->sales]);
        return;
    }

    public function updateDateObjetivoFat4()
    {
        // dd('Mês:'.$this->Month.'Ano:'.$this->Year);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SANIPOWER_URL_DIGITAL').'/api/analytics/top1000_objectives?Salesman_number='.Auth::user()->id_phc.'&year='.$this->Year.'&month='.$this->Month,
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
        // dd( env('SANIPOWER_URL_DIGITAL').'/api/analytics/objectives?Salesman_number=59&year='.$this->Year.'&month='.$this->Month, $response_decoded);
        if(isset($response_decoded->Message))
        {
            session(['objectiveOBJ4' => 0]);
            session(['salesOBJ4' => 0]);
            return;
        }

        session(['objectiveOBJ4' => $response_decoded->objective]);
        session(['salesOBJ4' => $response_decoded->sales]);
        return;
    }



    public function render()
    {
        // dd('AQUI');
        $this->INICIO = 1;
        return view('livewire.dashboard.analysis');
    }
}

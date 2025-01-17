<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\TiposVisitas;
use App\Models\VisitasAgendadas;
use App\Interfaces\VisitasInterface;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\Visitas;


class CalendarDashboard extends Component
{
    private ?object $visitasRepository = null;
    private ?object $clientesRepository = NULL;

    public ?object $listagemCalendario = null;

    public $tipoVisita;

    public $clientes;


    /** PARTE DO EDITAR ** */

    public $visitaID;
    public $clienteVisitaID;
    public $dataInicialVisita;
    public $horaInicialVisita;
    public $horaFinalVisita;
    public $tipoVisitaEscolhido;
    public $assuntoTextVisita;

    /********* */

    public $userSelected;
    public $comerciais;


    protected $listeners = ['visitaAddedEsquerda' => 'visitaArrived'];

    public function boot(VisitasInterface $visitasRepository,ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
        $this->visitasRepository = $visitasRepository;
    }

    public function mount()
    {
        $this->listagemCalendario = $this->visitasRepository->getListagemVisitasAgendadas(Auth::user()->id);

        $this->tipoVisita = TiposVisitas::all();

        // $this->comerciais = User::where('nivel','3')->get();

    }

    public function visitaArrived()
    {
        $this->listagemCalendario = $this->visitasRepository->getListagemVisitasAgendadas(Auth::user()->id);

        $this->tipoVisita = TiposVisitas::all();

        $this->dispatchBrowserEvent('restartCalendar');
    }

    public function editarVisita()
    {
      
        if($this->dataInicialVisita == "" ||$this->horaInicialVisita == "" || $this->horaFinalVisita == "" || $this->tipoVisitaEscolhido == "" || $this->assuntoTextVisita == "" )
        {
            $this->dispatchBrowserEvent('sendToaster', ["message" => "Tem de preencher todos os campos", "status" => "error"]);
            return false;
        }

        if(strtotime($this->horaInicialVisita) > strtotime($this->horaFinalVisita))
        {
            $this->dispatchBrowserEvent('sendToaster', ["message" => "Hora final tem de ser superior á hora inicial", "status" => "error"]);
            return false;
        }
    
        try {
           // Função para verificar e converter a data para o formato 'Y-m-d' se necessário
            function formatarData($data) {
                // Checa se o formato é dd-mm-yyyy e converte para yyyy-mm-dd
                if (preg_match("/^\d{2}-\d{2}-\d{4}$/", $data)) {
                    return Carbon::createFromFormat('d-m-Y', $data)->format('Y-m-d');
                }
                // Se já estiver no formato yyyy-mm-dd, retorna como está
                return $data;
            }

            // Aplica a função de verificação e formatação nas datas
            $dataInicial = formatarData($this->dataInicialVisita);
            // $dataFinal = formatarData($this->dataFinalVisita);
            
            $send = VisitasAgendadas::where('id', $this->visitaID)->update([
                "data_inicial" => $dataInicial,
                "hora_inicial" => $this->horaInicialVisita,
                "hora_final" => $this->horaFinalVisita,
                "data_final" => $dataInicial,
                "id_tipo_visita" => $this->tipoVisitaEscolhido,
                "assunto_text" => $this->assuntoTextVisita,
            ]);

            if ($send) {
                $message = "Visita atualizada com sucesso";
                $status = "success";
            } else {
                $message = "Nenhuma atualização foi feita!";
                $status = "warning";
            }
        } catch (\Exception $e) {
          
            $message = "Não foi possível atualizar a visita!";
            $status = "warning";
        }


        // $this->dispatchBrowserEvent('sendToasterr', ["message" => $message, "status" => $status]);
        // $this->dispatchBrowserEvent('restartCalendar');
        // $this->emit('reloadNotification');
        // $this->emit('visitaAdded');
        // $this->emit('updateLadoDireito');

        session()->flash($status, $message);
        return redirect()->route('dashboard');
    }

    public function EliminarAgendado()
    {
        $visitaAgendada = VisitasAgendadas::where('id', $this->visitaID)->first();
        // dd($visitaAgendada);
        if($visitaAgendada['finalizado'] != 0 || $visitaAgendada['user_id'] != Auth::user()->id)
        {
            $this->dispatchBrowserEvent('sendToaster', ["message" => "Só pode eliminar visitas agendadas!", "status" => "error"]);
            return false;
        }
        $visita = Visitas::where('id_visita_agendada', $this->visitaID)->first();
        // dd($visita);
        try {
            $send = VisitasAgendadas::where('id', $this->visitaID)->delete();
            $send1 = Visitas::where('id_visita_agendada', $this->visitaID)->delete();

            if ($send && $send1) {
                $message = "Visita Eliminada com sucesso";
                $status = "success";
            } else {
                $message = "Nenhuma atualização foi feita!";
                $status = "warning";
            }
        } catch (\Exception $e) {
            $message = "Não foi possível eliminar a visita!";
            $status = "warning";
        }

        session()->flash($status, $message);
        return redirect()->route('dashboard');
      
    }

    public function openVisita()
    {
        Session::put('rota','dashboard');
        Session::put('parametro',"");
        return redirect()->route('visitas.info', $this->visitaID);
    }

    public function updatedUserSelected()
    {
        if($this->userSelected == "0")
        {
            $this->listagemCalendario = $this->visitasRepository->getListagemVisitasAgendadas(Auth::user()->id);
        } else {
            $this->listagemCalendario = $this->visitasRepository->getVisitasFilter($this->userSelected);
        }

        $this->emit('changeTarefas',$this->userSelected);
        
        $this->dispatchBrowserEvent('restartCalendar');
    }

    public function render()
    {
        $this->clientes = [$this->clientesRepository->getAllListagemClientesObject()];
        $this->comerciais = User::where('nivel','3')->get();
        return view('livewire.dashboard.calendar-dashboard');
    }
}

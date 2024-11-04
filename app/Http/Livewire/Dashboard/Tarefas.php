<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Jobs\OfficeRequest;
use App\Models\TiposVisitas;
use App\Models\VisitasAgendadas;
use App\Interfaces\TarefasInterface;
use App\Interfaces\VisitasInterface;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Tarefas as TarefasModels;

class Tarefas extends Component
{
    private ?object $visitasRepository = null;
    private ?object $tarefasRepository = null;
    private ?object $clientesRepository = null;

    public ?array $listagemTarefas = null;

    public ?string $idTarefaTemp = null;
    public ?string $clienteTemp = null;
    public ?string $assuntoTemp = null;
    public ?string $descricaoTemp = null;

    public ?string $clienteNameTarefa = "";
    public ?string $dataInicialTarefa = "";
    public ?string $horaInicialTarefa = "";
    public ?string $horaFinalTarefa = "";
    public ?string $assuntoTarefa = "";
    public ?string $descricaoTarefa = "";

    public $iteration;

    public ?object $tipoVisita = NULL;
    public ?string $clienteVisitaID = "";
    public ?string $clienteVisitaName = "";
    public ?string $dataInicialVisita = "";
    public ?string $horaInicialVisita = "";
    public ?string $horaFinalVisita = "";
    public ?string $tipoVisitaEscolhidoVisita = "";
    public ?string $assuntoTextVisita = "";

    public ?array $clientes = NULL;


       /** PARTE DO EDITAR ** */

       public $visitaIDDireito;
       public $clienteVisitaIDDireito;
       public $dataInicialVisitaDireito;
       public $horaInicialVisitaDireito;
       public $horaFinalVisitaDireito;
       public $tipoVisitaEscolhidoDireito;
       public $assuntoTextVisitaDireito;
   
       /********* */

       public $flagReset = false;
       public $mesEscolhido = "";
       public $dayPicked;

       public $comercialPicked;

        protected $listeners = ['callAddVisita', 'callAddTarefa', "changeStatusTarefa" => "changeStatusTarefa", "getTarefaInfo" => "getTarefaInfo", "updateLadoDireito" => "updateladoDireito", "changeDashWithDate" => "changeDashWithDate", "originalData" => "originalData", "changeTarefas" => "handleChangeTarefas"];

    public function boot(VisitasInterface $visitasRepository, TarefasInterface $tarefaRepository, ClientesInterface $clientesInterface)
    {
        $this->visitasRepository = $visitasRepository;
        $this->tarefasRepository = $tarefaRepository;
        $this->clientesRepository = $clientesInterface;
    }

    public function mount()
    {
        $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);
        $this->flagReset = false;
        $this->dayPicked = "";
        $this->mesEscolhido = "";
        
    }

    public function changeStatusTarefa($idTarefa,$status)
    {
        $change = $this->tarefasRepository->changeStatusTarefa($idTarefa,$status);

        $responseArray = $change->getData(true);

        if ($responseArray["success"] == true) {
           
            $message = "Estado da tarefa alterado com sucesso!";
          
            $status = "success";
        } else {
            $message = "Não foi possivel alterar a tarefa!";
            $status = "error";
        }
     
        $this->originalData();
        //$this->dispatchBrowserEvent('updateList', ["message" => $message, "status" => $status]);
         $this->dispatchBrowserEvent('sendToaster', ["message" => $message, "status" => $status]);
         
    }

    public function getTarefaInfo($idTarefa)
    {
        $tarefa = TarefasModels::where('id',$idTarefa)->first();

        $this->clienteTemp = $tarefa->cliente;
        $this->assuntoTemp = $tarefa->assunto_text;
        $this->descricaoTemp = $tarefa->descricao;
        $this->idTarefaTemp = $tarefa->id;

        $this->dispatchBrowserEvent('openModalTarefa');
    }

    public function changeTarefa($tarefaID)
    {
        if($this->clienteTemp == "" || $this->assuntoTemp == "" || $this->descricaoTemp == "")
        {
            $message = "Tem de preencher todos os campos!";
            $status = "error";

            $this->dispatchBrowserEvent('sendToaster', ["message" => $message, "status" => $status]);

            return false;
        }

        $changeTarefa = $this->tarefasRepository->changeTarefaInformation($tarefaID,$this->clienteTemp, $this->assuntoTemp, $this->descricaoTemp);

        $responseArray = $changeTarefa->getData(true);

        if ($responseArray["success"] == true) {
           
            $message = "Tarefa alterada com sucesso!";
          
            $status = "success";
        } else {
            $message = "Não foi possivel alterar a tarefa!";
            $status = "error";
        }

        $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);
     
        $this->dispatchBrowserEvent('updateList', ["message" => $message, "status" => $status]);

    }

    public function addTarefaButton()
    {
        $this->tipoVisita = TiposVisitas::all();

        $this->dataInicialTarefa = ""; 
        $this->horaInicialTarefa = ""; 
        $this->horaFinalTarefa = "";  
        $this->assuntoTarefa = "";
        $this->descricaoTarefa = "";

        $collectionClientes = $this->tarefasRepository->getListagemCliente(10000);

        if (isset($collectionClientes->customers)) {
            $this->clientes = array_map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'name' => $cliente->name,
                ];
            }, $collectionClientes->customers);
        }
         
        // $this->clienteNameTarefa = json_encode($this->clientes[0]["name"]);
        $this->clienteNameTarefa = json_encode("Sem cliente");

        $this->dispatchBrowserEvent('openModalAddTarefa');
    }

    public function updateladoDireito()
    {
        $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);
        $this->dispatchBrowserEvent('updateList');
    }

    public function saveTarefa()
    {
        if($this->dataInicialTarefa == "" ||$this->horaInicialTarefa == "" || $this->horaFinalTarefa == "" || $this->assuntoTarefa == "" || $this->descricaoTarefa == "" )
        {
            $this->dispatchBrowserEvent('sendToaster', ["message" => "Tem de preencher todos os campos", "status" => "error"]);
            return false;
        }

        if(strtotime($this->horaInicialTarefa) > strtotime($this->horaFinalTarefa))
        {
            $this->dispatchBrowserEvent('sendToaster', ["message" => "Hora final tem de ser superior á hora inicial", "status" => "error"]);
            return false;
        }

       if(json_decode($this->clienteNameTarefa) == null)
       {
            $this->clienteNameTarefa = "Sem cliente";
       }

        $addTarefa = $this->tarefasRepository->addNewTarefa(json_decode($this->clienteNameTarefa),$this->dataInicialTarefa, $this->horaInicialTarefa, $this->horaFinalTarefa, $this->assuntoTarefa, $this->descricaoTarefa);

        $responseArray = $addTarefa->getData(true);

        if ($responseArray["success"] == true) {
           
            $message = "Tarefa adicionada com sucesso!";
          
            $status = "success";
        } else {
            $message = "Não foi possivel alterar a tarefa!";
            $status = "error";
        }

        $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);

     
        $this->dispatchBrowserEvent('sendToaster', ["message" => $message, "status" => $status]);
        $this->dispatchBrowserEvent('updateList', ["message" => $message, "status" => $status]);

        //continuar o insert
    }

    public function callAddVisita()
    {
        //dd('callAddVisita');
        $this->addVisita();
    }

    public function callAddTarefa()
    {
        //dd("callAddTarefa");
        $this->dispatchBrowserEvent('openModalAddTarefa');
        // $this->saveTarefa();
    }

    public function addVisita()
    {
        //dd('addVisita');
        $this->tipoVisita = TiposVisitas::all();

        $IDCli = Session::get('IDCli');   
        if($IDCli != '')
        {
            $collectionClientes = $this->tarefasRepository->getDetalhesCliente(json_decode($IDCli));

            if (isset($collectionClientes->customers)) {
                $this->clientes = array_map(function ($cliente) {
                    return [
                        'id' => $cliente->id,
                        'name' => $cliente->name,
                    ];
                }, $collectionClientes->customers);
            }
             
            
            if(isset($this->clientes[0]["id"]))
            {
                $this->clienteVisitaID = json_encode($this->clientes[0]["id"]);
            }
            
    
            $this->dispatchBrowserEvent('openVisitaModal');
        }
        else
        {
            $collectionClientes = $this->tarefasRepository->getListagemCliente(10000);

            if (isset($collectionClientes->customers)) {
                $this->clientes = array_map(function ($cliente) {
                    return [
                        'id' => $cliente->id,
                        'name' => $cliente->name,
                    ];
                }, $collectionClientes->customers);
            }
             
            
            if(isset($this->clientes[0]["id"]))
            {
                $this->clienteVisitaID = json_encode($this->clientes[0]["id"]);
            }
            
    
            $this->dispatchBrowserEvent('openVisitaModal');
        }
        
    }
    public function openVisita()
    {
        Session::put('rota','dashboard');
        Session::put('parametro',"");
        return redirect()->route('visitas.info', $this->visitaIDDireito);
    }
    public function editarVisitaDireito()
    {
        if($this->dataInicialVisitaDireito == "" ||$this->horaInicialVisitaDireito == "" || $this->horaFinalVisitaDireito == "" || $this->tipoVisitaEscolhidoDireito == "" || $this->assuntoTextVisitaDireito == "" )
        {
            $this->dispatchBrowserEvent('sendToaster', ["message" => "Tem de preencher todos os campos", "status" => "error"]);
            return false;
        }

        if(strtotime($this->horaInicialVisitaDireito) > strtotime($this->horaFinalVisitaDireito))
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
            $dataInicial = formatarData($this->dataInicialVisitaDireito);
            // $dataFinal = formatarData($this->dataFinalVisitaDireito);

            $send = VisitasAgendadas::where('id', $this->visitaIDDireito)->update([
                "data_inicial" => $dataInicial,
                "hora_inicial" => $this->horaInicialVisitaDireito,
                "hora_final" => $this->horaFinalVisitaDireito,
                "data_final" => $dataInicial,
                "id_tipo_visita" => $this->tipoVisitaEscolhidoDireito,
                "assunto_text" => $this->assuntoTextVisitaDireito,
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


        $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);

        // $this->emit('reloadNotification');
        // $this->emit('visitaAddedEsquerda');
        // $this->dispatchBrowserEvent('updateList');
        // $this->dispatchBrowserEvent('sendToaster', ["message" => $message, "status" => $status]);

        session()->flash($status, $message);
        return redirect()->route('dashboard');
      
    }

    

    public function agendaVisita()
    {
        if($this->clienteVisitaID == "" || $this->dataInicialVisita == "" ||$this->horaInicialVisita == "" || $this->horaFinalVisita == "" || $this->tipoVisitaEscolhidoVisita == "" || $this->assuntoTextVisita == "" )
        {
            Session::put('IDCli', $this->clienteVisitaID);
            // Session::put('rota','dashboard');

            $this->dispatchBrowserEvent('sendToaster', ["message" => "Tem de preencher todos os campos", "status" => "error"]);
            return false;
        }

        if(strtotime($this->horaInicialVisita) > strtotime($this->horaFinalVisita))
        {
            Session::put('IDCli', $this->clienteVisitaID);
            // Session::put('rota','dashboard');

            $this->dispatchBrowserEvent('sendToaster', ["message" => "Hora final tem de ser superior á hora inicial", "status" => "error"]);
            return false;
        }


        $nameClient = $this->tarefasRepository->getDetalhesCliente(json_decode($this->clienteVisitaID));

        $this->clienteVisitaName = $nameClient->customers[0]->name;
        
        $noClient = $nameClient->customers[0]->no;

        $response = $this->visitasRepository->addVisitaDatabase($noClient, json_decode($this->clienteVisitaID),$this->clienteVisitaName, preg_replace('/[a-zA-Z]/', '', $this->dataInicialVisita), preg_replace('/[a-zA-Z]/', '', $this->horaInicialVisita), preg_replace('/[a-zA-Z]/', '', $this->horaFinalVisita), $this->tipoVisitaEscolhidoVisita, $this->assuntoTextVisita);

        $tenant = env('MICROSOFT_TENANT');
        $clientId = env('MICROSOFT_CLIENT_ID');
        $clientSecret = env('MICROSOFT_CLIENT_SECRET');
        $redirectUri = env('MICROSOFT_REDIRECT');

        $emailEvento = Auth::user()->email;

        $responseArray = $response->getData(true);

        if ($responseArray["success"] == true) {
            $message = "Visita agendada com sucesso";
            $status = "success";
        } else {
            $message = "Não foi possivel adicionar a visita!";
            $status = "error";
        }

        $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);

        //$this->emit('reloadNotification');
        //$this->emit('visitaAdded');

        $this->dispatchBrowserEvent('sendToTeams',["tenant" => $tenant, "clientId" => $clientId, "clientSecret" => $clientSecret, "redirect" => $redirectUri, "visitaID" => json_decode($this->clienteVisitaID),"visitaName" =>$this->clienteVisitaName,"data" => preg_replace('/[a-zA-Z]/', '', $this->dataInicialVisita), "horaInicial" =>preg_replace('/[a-zA-Z]/', '', $this->horaInicialVisita), "horaFinal" => preg_replace('/[a-zA-Z]/', '', $this->horaFinalVisita), "tipoVisita" => $this->tipoVisitaEscolhidoVisita, "assunto" => $this->assuntoTextVisita, "email" => $emailEvento, "organizer" => Auth::user()->name ]);

        // $this->dispatchBrowserEvent('updateList');
        // $this->dispatchBrowserEvent('sendToaster', ["message" => $message, "status" => $status]);

        Session::put('IDCli', '');

        session()->flash($status, $message);
        return redirect()->route('dashboard');
    }

    public function agendaIniciarVisita()
    {
        if($this->clienteVisitaID == "" || $this->dataInicialVisita == "" ||$this->horaInicialVisita == "" || $this->horaFinalVisita == "" || $this->tipoVisitaEscolhidoVisita == "" || $this->assuntoTextVisita == "" )
        {
            Session::put('IDCli', $this->clienteVisitaID);
            // Session::put('rota','dashboard');

            $this->dispatchBrowserEvent('sendToaster', ["message" => "Tem de preencher todos os campos", "status" => "error"]);
            return false;
        }

        if(strtotime($this->horaInicialVisita) > strtotime($this->horaFinalVisita))
        {
            Session::put('IDCli', $this->clienteVisitaID);
            // Session::put('rota','dashboard');

            $this->dispatchBrowserEvent('sendToaster', ["message" => "Hora final tem de ser superior á hora inicial", "status" => "error"]);
            return false;
        }


        $nameClient = $this->tarefasRepository->getDetalhesCliente(json_decode($this->clienteVisitaID));

        $this->clienteVisitaName = $nameClient->customers[0]->name;

        $noClient = $nameClient->customers[0]->no;

        $response = $this->visitasRepository->addVisitaIniciarDatabase($noClient,json_decode($this->clienteVisitaID),$this->clienteVisitaName, preg_replace('/[a-zA-Z]/', '', $this->dataInicialVisita), preg_replace('/[a-zA-Z]/', '', $this->horaInicialVisita), preg_replace('/[a-zA-Z]/', '', $this->horaFinalVisita), $this->tipoVisitaEscolhidoVisita, $this->assuntoTextVisita);

        $tenant = env('MICROSOFT_TENANT');
        $clientId = env('MICROSOFT_CLIENT_ID');
        $clientSecret = env('MICROSOFT_CLIENT_SECRET');
        $redirectUri = env('MICROSOFT_REDIRECT');

        $emailEvento = Auth::user()->email;

        $responseArray = $response->getData(true);

        if ($responseArray["success"] == true) {
            $message = "Visita agendada com sucesso";
            $status = "success";
        } else {
            $message = "Não foi possivel adicionar a visita!";
            $status = "error";
        }

        $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);

        //$this->emit('reloadNotification');
        //$this->emit('visitaAdded');

        $this->dispatchBrowserEvent('sendToTeams',["tenant" => $tenant, "clientId" => $clientId, "clientSecret" => $clientSecret, "redirect" => $redirectUri, "visitaID" => json_decode($this->clienteVisitaID),"visitaName" =>$this->clienteVisitaName,"data" => preg_replace('/[a-zA-Z]/', '', $this->dataInicialVisita), "horaInicial" =>preg_replace('/[a-zA-Z]/', '', $this->horaInicialVisita), "horaFinal" => preg_replace('/[a-zA-Z]/', '', $this->horaFinalVisita), "tipoVisita" => $this->tipoVisitaEscolhidoVisita, "assunto" => $this->assuntoTextVisita, "email" => $emailEvento, "organizer" => Auth::user()->name ]);

        // $this->dispatchBrowserEvent('updateList');
        // $this->dispatchBrowserEvent('sendToaster', ["message" => $message, "status" => $status]);

        Session::put('IDCli', '');

        session()->flash($status, $message);
        return redirect()->route('dashboard');
    }

    public function changeDashWithDate($data,$checkComercial)
    {
      
        if($checkComercial == 0)
        {
            $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefasWithDate(Auth::user()->id,$data);
        } else {
            $this->listagemTarefas = $this->visitasRepository->getVisitasTarefasDateFilter($checkComercial,$data);
        }

        $this->comercialPicked = $checkComercial;
       
        $this->flagReset = true;
        $this->dayPicked = date('Y-m-d',strtotime($data));
        $this->mesEscolhido = date('Y-m',strtotime($data));
        $this->dispatchBrowserEvent('updateList');
    }


    public function originalData()
    {
        
        if($this->comercialPicked == "0")
        {
            $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);
        } 
        else if($this->comercialPicked == null)
        {
            $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);
        }
        else {
            $this->listagemTarefas = $this->visitasRepository->getTarefasFilter($this->comercialPicked);
        }
       
        $this->flagReset = false;
        $this->dayPicked = "";
        $this->mesEscolhido = "";
        $this->dispatchBrowserEvent('updateList');
    }

    public function handleChangeTarefas($id)
    {
        if($id == "0")
        {
            $this->listagemTarefas = $this->visitasRepository->getListagemVisitasAndTarefas(Auth::user()->id);
        } else {
            $this->listagemTarefas = $this->visitasRepository->getTarefasFilter($id);
        }
       
        $this->dispatchBrowserEvent('updateList');
    }

    public function render()
    {
        $this->clientes = [$this->clientesRepository->getAllListagemClientesObject()];
        $this->tipoVisita = TiposVisitas::all();
        return view('livewire.dashboard.tarefas');
    }
}

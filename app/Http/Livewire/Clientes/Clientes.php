<?php

namespace App\Http\Livewire\Clientes;

use App\Mail\CriarCliente;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Component;
use App\Interfaces\ClientesInterface;
use App\Repositories\ClientesRepository;
use Livewire\WithPagination;


class Clientes extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public int $pageChosen = 1;
    public int $numberMaxPages;
    public int $totalRecords = 0;
    private ?object $clientesRepository = NULL;
    protected ?object $clientes = NULL;

    public ?string $nomeCliente = '';
    public ?string $numeroCliente = '';
    public ?string $zonaCliente = '';
    public ?string $telemovelCliente = '';
    public ?string $emailCliente = '';
    public ?string $nifCliente = '';
    public ?string $criarnomeCliente = '';
    public ?string $criarnumeroCliente = '';
    public ?string $criarzonaCliente = '';
    public ?string $criarnumContribuinte = '';
    public $erroConsulta;



    public function boot(ClientesInterface $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
    }
    // Teste do Git
    private function initProperties(): void
    {
        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

        $this->nomeCliente = '';
        $this->numeroCliente = '';
        $this->zonaCliente = '';
        $this->telemovelCliente = '';
        $this->emailCliente = '';
        $this->nifCliente = '';

    }

    public function mount()
    {
        $this->initProperties();
        $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage, $this->pageChosen);
    
        if (!$arrayClientes["paginator"]) {
            // Armazena uma flag indicando erro
            session()->flash('status', 'error');
            session()->flash('message', 'Ocorreu um erro ao tentar consultar os clientes.(erro: CL-401)');
            $this->erroConsulta = true;
        } else {
            $this->clientes = $arrayClientes["paginator"];
            $this->numberMaxPages = $arrayClientes["nr_paginas"];
            $this->totalRecords = $arrayClientes["nr_registos"];
        }
    }
    
    public function updatedNomeCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"] + 1;
        $this->totalRecords = $arrayClientes["nr_registos"];

    }

    public function criarCliente()
    {
        $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
        $this->clientes = $arrayClientes["paginator"];
     

        $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
        $this->totalRecords = $arrayClientes["nr_registos"];


        $this->dispatchBrowserEvent('openClienteModal');
    }

    public function salvarCliente()
    {
        $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
        $this->clientes = $arrayClientes["paginator"];
     

        $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
        $this->totalRecords = $arrayClientes["nr_registos"];
    
        $camposPreenchidos = !empty($this->criarnomeCliente) && !empty($this->criarnumeroCliente) && !empty($this->criarzonaCliente) && !empty($this->criarnumContribuinte);
    
        $numClienteNumerico = ctype_digit($this->criarnumeroCliente);
        $numContribuinteNumerico = ctype_digit($this->criarnumContribuinte);
    
        if ($camposPreenchidos && $numClienteNumerico && $numContribuinteNumerico) {
            $this->dispatchBrowserEvent('checkToaster', ['status' => 'success', 'message' => 'Email enviado com sucesso!']);
    
            // Obtenha o usuário logado
            $user = Auth::user();
    
            // Envie o email
            
            // Mail::to($user->email)->send(new CriarCliente($this->criarnomeCliente, $this->criarnumeroCliente, $this->criarzonaCliente, $this->criarnumContribuinte));
    
            $this->limparCampos();
            dd("Email nao enviado ao utilizador.");
        } else {
            $this->dispatchBrowserEvent('checkToaster', ['status' => 'error', 'message' => 'Por favor, preencha todos os campos corretamente!']);
        }
    }
    

    private function limparCampos()
    {

        $this->criarnomeCliente = '';
        $this->criarnumeroCliente = '';
        $this->criarzonaCliente = '';
        $this->criarnumContribuinte = '';
    }

    public function updatedNumeroCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
        $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedZonaCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
        $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedNifCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
        $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedTelemovelCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
        $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function updatedEmailCliente()
    {
        $this->pageChosen = 1;
        $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
        
        $this->clientes = $arrayClientes["paginator"];
        $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
        $this->totalRecords = $arrayClientes["nr_registos"];
    }

    public function gotoPage($page)
    {
        $this->pageChosen = $page;

        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
            $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
            $this->clientes = $arrayClientes["paginator"];
        } else {
            $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
            $this->clientes = $arrayClientes["paginator"];
        }

    }


    public function previousPage()
    {
        if ($this->pageChosen > 1) {
            $this->pageChosen--;

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
                $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
                $this->clientes = $arrayClientes["paginator"];
            }
        }
        else if($this->pageChosen == 1){
            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
                $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
                $this->clientes = $arrayClientes["paginator"];
            }
        }
    }

    public function nextPage()
    {
        if ($this->pageChosen < $this->numberMaxPages) {
            $this->pageChosen++;

            if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
                $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
                $this->clientes = $arrayClientes["paginator"];
            } else {
                $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
                $this->clientes = $arrayClientes["paginator"];
            }
        }
    }

    public function getPageRange()
    {
        $currentPage = $this->pageChosen;
        $lastPage = $this->numberMaxPages;

        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);

        return range($start, $end);
    }

    public function isCurrentPage($page)
    {
        return $page == $this->pageChosen;
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
        session()->put('perPage', $this->perPage);

        if($this->nomeCliente != "" || $this->numeroCliente != ""  || $this->zonaCliente != "" || $this->telemovelCliente != "" || $this->emailCliente != "" || $this->nifCliente != ""){
            $arrayClientes = $this->clientesRepository->getListagemClienteFiltro($this->perPage,$this->pageChosen,$this->nomeCliente,$this->numeroCliente,$this->zonaCliente,$this->telemovelCliente,$this->emailCliente,$this->nifCliente);
            $this->clientes = $arrayClientes["paginator"];

            $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
            $this->totalRecords = $arrayClientes["nr_registos"];
        } else {
            $arrayClientes = $this->clientesRepository->getListagemClientes($this->perPage,$this->pageChosen);
            $this->clientes = $arrayClientes["paginator"];
        

            $this->numberMaxPages = $arrayClientes["nr_paginas"]+ 1;
            $this->totalRecords = $arrayClientes["nr_registos"];
        }

    }
    public function openDetailCliente($id)
    {
        session(['rota' => "clientes"]);
        session(['parametro' => ""]);

        return redirect()->route('clientes.detail',["id" => $id]);

    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {   
        if ($this->erroConsulta == true) {
            // Aqui você redireciona para a rota 'dashboard', mudando a URL corretamente
            return view('dashboard');
        }
    
        // Caso não haja erro, renderiza a view dos clientes
        return view('livewire.clientes.clientes', ["clientes" => $this->clientes]);
    }
    
}

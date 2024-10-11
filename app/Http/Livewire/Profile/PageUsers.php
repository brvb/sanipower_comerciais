<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\User;
use App\Models\GrupoEmail;
use Livewire\WithPagination;

class PageUsers extends Component
{
    use WithPagination;
    protected $listeners = ['refreshTable' => '$refresh'];
    public $filterNome;
    public $filterEmail;
    public $filterTelemovel;
    public $totalRecords;
    public $pageChosen;
    public $perPage;
    public $numberMaxPages;
    public $titulo;
    public $descricao;
    public $emails;
    public $grupoId;
    public $local_funcionamento;


    protected $rules = [
        'titulo' => 'required|string|max:50',
        'descricao' => 'nullable|string|max:250',
        'emails' => 'required|string',
        'local_funcionamento' => 'required|string'
    ];
    
    private function initProperties(): void
    {
        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
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

    public function mount()
    {
        $this->initProperties();
    }

    public function updatingFilterNome()
    {
        $this->resetPage();
        $this->emit('filtersUpdated');
    }

    public function updatingFilterEmail()
    {
        $this->resetPage();
        $this->emit('filtersUpdated');
    }

    public function updatingFilterTelemovel()
    {
        $this->resetPage();
        $this->emit('filtersUpdated');
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function isCurrentPage($page)
    {
        return $page == $this->pageChosen;
    }
    public function salvarGrupo()
    {
        $this->validate();

        GrupoEmail::updateOrCreate(
            ['id' => $this->grupoId],
            [
                'titulo' => $this->titulo,
                'descricao' => $this->descricao,
                'emails' => $this->emails,
                'local_funcionamento' => $this->local_funcionamento
            ]
        );
        

        $this->dispatchBrowserEvent('close-modal');

        $this->reset(['titulo', 'descricao', 'emails', 'grupoId']);

        session()->flash('message', 'Grupo de email salvo com sucesso!');
    }
    public function edit($id)
    {
        $grupo = GrupoEmail::findOrFail($id);
        $this->grupoId = $grupo->id;
        $this->titulo = $grupo->titulo;
        $this->descricao = $grupo->descricao;
        $this->emails = $grupo->emails;
        $this->local_funcionamento = $grupo->local_funcionamento;
    
        // Emitir evento para abrir o modal de edição
        $this->dispatchBrowserEvent('open-edit-modal');
    }
    

    public function delete($id)
    {
        $grupo = GrupoEmail::find($id);
        if ($grupo) {
            $grupo->delete();
            session()->flash('message', 'Grupo deletado com sucesso!');
        }
    }
    public function render()
    {

        $grupos = GrupoEmail::all();
        $users = User::query()
            ->when($this->filterNome, function($query) {
                $query->where('name', 'like', '%' . $this->filterNome . '%');
            })
            ->when($this->filterEmail, function($query) {
                $query->where('email', 'like', '%' . $this->filterEmail . '%');
            })
            ->when($this->filterTelemovel, function($query) {
                $query->where('telefone', 'like', '%' . $this->filterTelemovel . '%');
            })
            ->paginate($this->perPage);
        $this->totalRecords = $users->total();
        $this->pageChosen = $users->currentPage();
        $this->numberMaxPages = $users->lastPage();

        return view('livewire.profile.page-users', [
            'users' => $users,'grupos' => $grupos
        ]);
    }
}

<?php

namespace App\Http\Livewire\Campanhas;

use Livewire\Component;
use App\Models\TiposVisitas;
use App\Models\VisitasAgendadas;
use App\Interfaces\VisitasInterface;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientesInterface;
use App\Models\User;
use App\Models\DashboardPreference;
use App\Models\Campanhas;


class Campanha extends Component
{
    public $show90dias = 0;
    public $showObjFat = 0;
    public $showTop500 = 0;
    public $showObjMargin = 0;

    public function mount()
    {
        // Carrega as preferências atuais do usuário, se existirem
        // $preferences = DashboardPreference::where('Id_user', Auth::id())->first();
        
        // if ($preferences) {
        //     $this->show90dias = $preferences->days90 == 1 ? true : false;
        //     $this->showObjFat = $preferences->ObjFat == 1 ? true : false;
        //     $this->showTop500 = $preferences->Top500 == 1 ? true : false;
        //     $this->showObjMargin = $preferences->ObjMargin == 1 ? true : false;
        // }
    }


    public function render()
    {
        $campanhas = Campanhas::where('ativa', 1)
        ->where('destaque', 1)
        ->where('dh_fim', '>', now())
        ->get();
        return view('livewire.Campanhas.campanhas', [
            "products" => $campanhas
        ]);
    }
}

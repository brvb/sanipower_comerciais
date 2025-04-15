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

class EditDashboard extends Component
{
    public $show90dias = 0;
    public $showObjFat = 0;
    public $showTop500 = 0;
    public $showTop1000 = 0;
    public $showObjMargin = 0;
    public $showSlsCus = 0;

    public function mount()
    {
        // Carrega as preferências atuais do usuário, se existirem
        $preferences = DashboardPreference::where('Id_user', Auth::id())->first();
        
        if ($preferences) {
            $this->show90dias = $preferences->days90 == 1 ? true : false;
            $this->showObjFat = $preferences->ObjFat == 1 ? true : false;
            $this->showTop500 = $preferences->Top500 == 1 ? true : false;
            $this->showTop1000 = $preferences->Top1000 == 1 ? true : false;
            $this->showObjMargin = $preferences->ObjMargin == 1 ? true : false;
        }
    }

    public function savePreferences()
    {
        // Converta os valores de checkbox para 0 ou 1
        $this->show90dias = $this->show90dias ? 1 : 0;
        $this->showObjFat = $this->showObjFat ? 1 : 0;
        $this->showTop500 = $this->showTop500 ? 1 : 0;
        $this->showTop1000 = $this->showTop1000 ? 1 : 0;
        $this->showObjMargin = $this->showObjMargin ? 1 : 0;
        // dd($this);
        // Procura ou cria as preferências do usuário
        $preferences = DashboardPreference::updateOrCreate(
            ['Id_user' => Auth::id()],
            [
                'days90' => $this->show90dias,
                'ObjFat' => $this->showObjFat,
                'Top500' => $this->showTop500,
                'Top1000' => $this->showTop1000,
                'ObjMargin' => $this->showObjMargin,
            ]
        );

        session()->flash('message', 'Preferências salvas com sucesso.');
    }

    public function render()
    {
        return view('livewire.dashboard.edit-dashboard');
    }
}

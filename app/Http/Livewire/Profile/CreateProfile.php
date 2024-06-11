<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreateProfile extends Component
{
    use WithFileUploads;

    public $ErroPasswordNotRepet;

    public $imagemPerfil;
    public $styleButton;

    public $Nivel;
    public $Status;
    public $Email;
    public $TelemovelUser;
    public $nomeUser;
    public $Senha;
    public $ConfirmeSenha;

    public function mount()
    {
        $this->styleButton = "none";
    }

    public function CriarUser()
    {
        $this->validate([
            'nomeUser' => 'required',
            'Nivel' => 'required',
            'Status' => 'required',
            'Email' => 'required',
            'TelemovelUser' => 'required',
            'Senha' => 'required',
            'ConfirmeSenha' => 'required',
        ]);
        if($this->Senha == $this->ConfirmeSenha){
            if ($this->imagemPerfil) {
                $fileName = $this->imagemPerfil->getClientOriginalName();
            } else {
                $fileName = "";
            }

            $this->ErroPasswordNotRepet = "";
            User::create([
                'name' => $this->nomeUser,
                'nivel' => $this->Nivel,
                'status' => $this->Status,
                'email' => $this->Email,
                'imagem' => $fileName,
                'telefone' => $this->TelemovelUser,
                'password' => $this->Senha,
            ]);
            return redirect()->route('profile.create')->with('message', 'Usuario criado com sucesso!')->with('status', 'success');
        }else
        {
            $this->ErroPasswordNotRepet = "Activo";
        }

    } 
    public function updatedImagemPerfil()
    {
        $this->styleButton = "block";
    }
    public function salvarImagem()
    {
        User::where('id', Auth::user()->id)->update([
            'imagem' => $this->imagemPerfil->getClientOriginalName(),
        ]);
        session()->flash('success', "Imagem alterada com sucesso");
        return redirect()->route('profile.edit');
    }

    public function render()
    {
        return view('livewire.profile.create-profile');
    }
    
}
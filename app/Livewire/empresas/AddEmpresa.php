<?php
namespace App\Livewire\empresas;

use App\Models\Prestadores;
use App\Models;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Livewire\Component;

class AddEmpresa extends Component
{
    public ?string $nomeEmpresa = "";
    public ?string $emailEmpresa = "";
    public ?string $enderecoEmpresa = "";
    public ?string $contactoEmpresa = "";
    public ?string $especializacaoEmpresa = "";
    public ?string $contribuinteEmpresa = "";
    public ?string $imagemEmpresa = "";
    public ?string $data_criacaoEmpresa = "";

    public ?string $nomeUsuario = "";
    public ?string $apelidoUsuario = "";
    public ?string $emailUsuario = "";
    public ?string $senhaUsuario = "";


    public ?string $message = "";

    public function criar()
    {
        $this->validate([
            'nomeEmpresa' => 'required|string|max:255',
            'emailEmpresa' => 'required|email|unique:Prestadores,email',
            'enderecoEmpresa' => 'required|string|max:255',
            'contactoEmpresa' => 'required|string|max:20',
            'especializacaoEmpresa' => 'nullable|string|max:255',
            'contribuinteEmpresa' => 'required|string|max:50|unique:Prestadores,contribuinte',
            'imagemEmpresa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'data_criacaoEmpresa' => 'required|date',

            'nomeUsuario' => 'required|string|max:255',
            'apelidoUsuario' => 'required|string|max:255',
            'emailUsuario' => 'required|email|unique:users,email',
            'senhaUsuario' => 'required',
        ]);

         try {
            $Prestadores = Prestadores::create([
                'nome' => $this->nomeEmpresa,
                'email' => $this->emailEmpresa,
                'endereco' => $this->enderecoEmpresa,
                'contacto' => $this->contactoEmpresa,
                'especializacao' => $this->especializacaoEmpresa,
                'contribuinte' => $this->contribuinteEmpresa,
                'imagem' => $this->imagemEmpresa,
                'qtd_usuarios' => 1,
                'status' => "active",
                'data_criacao' => $this->data_criacaoEmpresa,
            ]);

            User::create([
                'name' => $this->nomeUsuario,
                'apelido' => $this->apelidoUsuario,
                'email' => $this->emailUsuario,
                'id_prestadores' => $Prestadores->id,
                'function' => 0,
                'nivel' => 1,
                'password' => Hash::make($this->senhaUsuario)
            ]);

            $this->message = "Empresa adicionada com sucesso.";
            $this->dispatch('alert', ['type' => 'success', 'message' => $this->message]);

        } catch (Exception $e) {

            $this->message = "Erro ao adicionar a empresa: " . $e->getMessage();
            $this->dispatch('alert', ['type' => 'error', 'message' => $this->message]);
        }
    }

    public function render()
    {
        return view('livewire.empresas.add-empresa');
    }
}

<?php
namespace App\Livewire\empresas;

use App\Models\Prestadores;
use Livewire\Component;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EditEmpresa extends Component
{
    public ?string $nomeEmpresa = "";
    public ?string $emailEmpresa = "";
    public ?string $enderecoEmpresa = "";
    public ?string $contactoEmpresa = "";
    public ?string $especializacaoEmpresa = "";
    public ?string $contribuinteEmpresa = "";
    public ?string $imagemEmpresa = "";
    public ?string $data_criacaoEmpresa = "";
    public ?string $statusEmpresa = "";

    public ?string $message = "";
    public Prestadores $empresa;
    public Collection $funcionarios; // Alterado para Collection

    public function mount($id)
    {
        $this->empresa = Prestadores::find($id);

        $this->funcionarios = User::where("id_prestadores", $this->empresa->id)->get();

        // dd($this->funcionarios);

        $this->statusEmpresa = $this->empresa->status;
        $this->nomeEmpresa = $this->empresa->nome;
        $this->emailEmpresa = $this->empresa->email;
        $this->enderecoEmpresa = $this->empresa->endereco;
        $this->contactoEmpresa = $this->empresa->contacto;
        $this->especializacaoEmpresa = $this->empresa->especializacao;
        $this->contribuinteEmpresa = $this->empresa->contribuinte;
        $this->imagemEmpresa = $this->empresa->imagem;
        $this->data_criacaoEmpresa = $this->empresa->data_criacao;
    }

    public function atualizar()
    {
        $this->validate([
            'nomeEmpresa' => 'required|string|max:255',
            'emailEmpresa' => 'required|email|unique:Prestadores,email,' . $this->empresa->id, // Ignorar o e-mail da empresa atual
            'enderecoEmpresa' => 'required|string|max:255',
            'contactoEmpresa' => 'required|string|max:20',
            'statusEmpresa' => 'required|string|max:255',
            'especializacaoEmpresa' => 'nullable|string|max:255',
            'contribuinteEmpresa' => 'required|string|max:50|unique:Prestadores,contribuinte,' . $this->empresa->id, // Ignorar o contribuinte da empresa atual
            'imagemEmpresa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'data_criacaoEmpresa' => 'required|date',
        ]);

        try {
            // Atualizar os dados da empresa
            $this->empresa->update([
                'nome' => $this->nomeEmpresa,
                'email' => $this->emailEmpresa,
                'endereco' => $this->enderecoEmpresa,
                'contacto' => $this->contactoEmpresa,
                'especializacao' => $this->especializacaoEmpresa,
                'contribuinte' => $this->contribuinteEmpresa,
                'status' => $this->statusEmpresa,
                'imagem' => $this->imagemEmpresa,
                'data_criacao' => $this->data_criacaoEmpresa,
            ]);

            $this->message = "Empresa atualizada com sucesso.";
            $this->dispatch('alert', ['type' => 'success', 'message' => $this->message]);

        } catch (Exception $e) {
            $this->message = "Erro ao atualizar a empresa: " . $e->getMessage();
            $this->dispatch('alert', ['type' => 'error', 'message' => $this->message]);
        }
    }

    public function render()
    {
        return view('livewire.empresas.edit-empresa');
    }
}

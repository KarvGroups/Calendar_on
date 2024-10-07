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

    public ?string $nome = "";
    public ?string $apelido = "";
    public ?string $email = "";
    public ?string $contacto = "";
    public ?string $especializacao = "";
    public ?string $status = "active";
    public ?string $password = "";
    public ?string $passwordConfirm = "";

    public bool $showCreateUserForm = false;

    public ?string $message = "";
    public Prestadores $empresa;
    public Collection $funcionarios; // Alterado para Collection

    public ?int $userId = null;
    public bool $showEditUserModal = false;


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
            'emailEmpresa' => 'required|email|unique:Prestadores,email,' . $this->empresa->id,
            'enderecoEmpresa' => 'required|string|max:255',
            'contactoEmpresa' => 'required|string|max:20',
            'statusEmpresa' => 'required|string|max:255',
            'especializacaoEmpresa' => 'nullable|string|max:255',
            'contribuinteEmpresa' => 'required|string|max:50|unique:Prestadores,contribuinte,' . $this->empresa->id,
            'imagemEmpresa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'data_criacaoEmpresa' => 'required|date',
        ]);

        try {

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
    public function criarUser()
    {
        $this->showCreateUserForm = true;
        $this->validate([
            'nome' => 'required|string|max:255',
            'apelido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contacto' => 'required|string|max:20',
            'status' => 'required|string|in:active,inactive',
            'password' => 'required|string|min:6',
            'passwordConfirm' => 'required|same:password',
        ]);

        try {
            User::create([
                'name' => $this->nome,
                'apelido' => $this->apelido,
                'email' => $this->email,
                'contacto' => $this->contacto,
                'status' => $this->status,
                'function' => 1,
                'nivel' => 1,
                'password' => bcrypt($this->password),
                'id_prestadores' => $this->empresa->id,
            ]);

            $this->reset(['nome', 'apelido', 'email', 'contacto', 'especializacao', 'status', 'password', 'passwordConfirm']);

            $this->message = "Usuário criado com sucesso.";
            $this->dispatch('alert', ['type' => 'success', 'message' => $this->message]);

        } catch (\Exception $e) {
            $this->message = "Erro ao criar o usuário: " . $e->getMessage();
            $this->dispatch('alert', ['type' => 'error', 'message' => $this->message]);
        }
    }
    public function editarUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $this->userId = $user->id;
            $this->nome = $user->name;
            $this->apelido = $user->apelido;
            $this->email = $user->email;
            $this->contacto = $user->contacto;
            $this->especializacao = $user->especializacao;
            $this->status = $user->status;

            // Exibir o modal de edição
            $this->showEditUserModal = true;
        }
    }
    public function atualizarUser()
    {
        $this->validate([
            'nome' => 'required|string|max:255',
            'apelido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'contacto' => 'required|string|max:20',
            'status' => 'required|string|in:active,inactive',
            'password' => 'nullable|string|min:6',
            'passwordConfirm' => 'same:password',
        ]);
        if ($this->userId) {
            $user = User::find($this->userId);

            if ($user) {
                $user->update([
                    'name' => $this->nome,
                    'apelido' => $this->apelido,
                    'email' => $this->email,
                    'contacto' => $this->contacto,
                    'especializacao' => $this->especializacao,
                    'status' => $this->status,
                ]);
                // Atualizar a senha apenas se uma nova senha for fornecida
                if (!empty($this->password)) {
                    $user->update([
                        'password' => bcrypt($this->password),
                    ]);
                }

                $this->message = "Usuário atualizado com sucesso.";
                $this->dispatch('alert', ['type' => 'success', 'message' => $this->message]);

                // Fechar o modal e limpar os campos
                $this->reset(['userId', 'nome', 'apelido', 'email', 'contacto', 'especializacao', 'status', 'password', 'passwordConfirm', 'showEditUserModal']);
            }
        }
    }



    public function render()
    {
        return view('livewire.empresas.edit-empresa');
    }
}

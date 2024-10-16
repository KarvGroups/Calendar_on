<div class="container">
    <div class="row">
        @foreach($users as $user)
            <div class="col-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">{{ $user->email }}</p>
                        <button wire:click="selectUser({{ $user->id }})" class="btn btn-primary">
                            Selecionar
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($selectedUser)
        <div class="alert alert-info mt-4">
            Utilizador selecionado: {{ $users->find($selectedUser)->name }}
        </div>
    @endif
</div>

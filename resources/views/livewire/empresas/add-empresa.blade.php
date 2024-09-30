<div>
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4 class="card-title">Dados da Empresa</h4>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Nome da empresa</label>
                            <input type="text" wire:model.defer="nomeEmpresa" class="form-control" />
                            @error('nomeEmpresa') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Endereço</label>
                            <input type="text" wire:model.defer="enderecoEmpresa" class="form-control" />
                            @error('enderecoEmpresa') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Email</label>
                            <input type="email" wire:model.defer="emailEmpresa" class="form-control" />
                            @error('emailEmpresa') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Número de contacto</label>
                            <input type="tel" wire:model.defer="contactoEmpresa" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required/>
                            @error('contactoEmpresa') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Contribuinte</label>
                            <input type="text" wire:model.defer="contribuinteEmpresa" class="form-control" />
                            @error('contribuinteEmpresa') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Data de criação</label>
                            <input type="date" wire:model.defer="data_criacaoEmpresa" class="form-control" />
                            @error('data_criacaoEmpresa') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Especializações </label>
                            <select class="js-example-basic-single" wire:model.defer="especializacaoEmpresa" style="width:100%">
                                <option value="Cabeleireira">Cabeleireira</option>
                                <option value="Estética">Estética</option>
                            </select>
                            @error('especializacaoEmpresa') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                </div>
                <div class="row">
                    <h4 class="card-title">Dados do Administrador</h4>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Nome Completo</label>
                            <input type="text" wire:model.defer="nomeUsuario" class="form-control" />
                            @error('nomeUsuario') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Apelido</label>
                            <input type="text" wire:model.defer="apelidoUsuario" class="form-control" />
                            @error('apelidoUsuario') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Email</label>
                            <input type="email" wire:model.defer="emailUsuario" class="form-control" />
                            @error('emailUsuario') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Senha</label>
                            <input type="text" wire:model.defer="senhaUsuario" class="form-control" />
                            @error('senhaUsuario') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button wire:click="criar" class="btn btn-gradient-primary mb-2">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('alert', event => {
            Swal.fire({
                title: 'Sucesso!',
                text: event.detail.message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
</div>

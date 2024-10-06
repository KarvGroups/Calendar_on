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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=" col-form-label">Especializações </label>
                            <select class="js-example-basic-single" wire:model.defer="statusEmpresa" style="width:100%">
                                <option value="active">Ativo</option>
                                <option value="inactive">Inativo</option>
                            </select>
                            @error('statusEmpresa') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button wire:click="atualizar" class="btn btn-gradient-primary mb-2">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                   <h4 class="card-title">Usuarios</h4>
                   <button type="button" class="btn btn-sm btn-gradient-primary">
                    <i class="fa fa-plus"></i>
                </button>
                </div>


                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th> Imagem </th>
                        <th> Nome </th>
                        <th> apelido </th>
                        <th> E-mail </th>
                        <th> Função </th>
                        <th> Status </th>
                        <th> Ações </th>

                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($funcionarios as $funcionario)
                          <tr>
                              <td class="py-1">
                                  <img src="../../assets/images/faces-clipart/pic-1.png" alt="image" />
                              </td>
                              <td> {{$funcionario->name}} </td>
                              <td> {{$funcionario->apelido}} </td>
                              <td> {{$funcionario->email}} </td>
                              <td>
                                @if($funcionario->function == 0)
                                    admin
                                @endif
                            </td>

                              <td> {{$funcionario->status}} </td>
                              <td>
                                  <button type="button" class="btn btn-sm btn-gradient-primary btn-rounded btn-icon">
                                      <i class="fa fa-pencil"></i>
                                  </button>
                              </td>
                          </tr>
                      @endforeach

                    </tbody>
                  </table>
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

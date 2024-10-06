<div>
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body" style="padding:18px">
                <div class="d-flex justify-content-between">

                    <p class="d-inline-flex gap-1">
                        <a class="btn btn-sm btn-primary"  data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-search"></i>
                        </a>
                    </p>

                    <p class="d-inline-flex gap-1">
                        <a class="btn btn-sm btn-primary" href="{{ route('empresas.create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                        <a class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#ModalAddEmpresa" data-bs-whatever="@getbootstrap">
                            <i class="fa fa-send"></i>
                        </a>
                    </p>
                </div>

                <div class="collapse" id="collapseExample">
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Username">Username</label>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                        </div>

                        <div class="col-md-6 ">

                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="text" class="form-control"  placeholder="Email">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Empresas</h4>
            </p>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Imagem </th>
                  <th> Nome </th>
                  <th> E-mail </th>
                  <th> Espaço </th>
                  <th> Usuarios </th>
                  <th> Status </th>
                  <th> Ações </th>

                </tr>
              </thead>
              <tbody>
                @foreach ($prestadores as $prestador)
                    <tr>
                        <td class="py-1">
                            <img src="../../assets/images/faces-clipart/pic-1.png" alt="image" />
                        </td>
                        <td> {{$prestador->nome}} </td>
                        <td> {{$prestador->email}} </td>
                        <td>
                            <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>{{$prestador->qtd_usuarios}}</td>
                        <td> {{$prestador->status}} </td>
                        <td>
                            <button type="button" wire:click='edit( {{$prestador->id}} )' class="btn btn-sm btn-gradient-primary btn-rounded btn-icon">
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
    {{-- modal --}}
    <div class="modal fade" id="ModalAddEmpresa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Nova Empresa</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="forms-sample">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Username</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Confirm Password</label>
                        <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-gradient-primary">Enviar</button>
            </div>
          </div>
        </div>
      </div>
      {{-- Fim modal --}}
</div>

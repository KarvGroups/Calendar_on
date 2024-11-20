<div>
    <style>
        ul {
            list-style: none;
            padding: 0;
        }
        .sortable-list li {
            background: #98909d12;
            color: #000000;
            padding: 5px 10px;
            margin: 5px 5px;
            border-radius: 10px;
            cursor: grab;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .div-user {
            background: #94909633;
            padding: 5px;
            margin: 10px;
            border-radius: 10px;
            display: flex;
            color: rgb(0, 0, 0);
            align-items: center;
        }
        .div-user:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .div-user-active{
            background: linear-gradient(to right, #da8cff, #9a55ff);
            color: rgb(255, 255, 255);
        }
        .div-user img {
            width: 50px;
            height: 50px;
            background-size: cover;
            background-position: center;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 10px
        }
        .div-user p{
            font-size: 12px;
            opacity: 65%;
        }
        .contaner-user {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .contaner-user .item-contaner {
            flex: 1 1 auto;

        }
        .div-button-edit{
            display: flex;
            justify-content: flex-end;
        }
        .div-button-edit button{
            margin-right: 10px;
        }
    </style>
    <div>
        <div class="card">
            <div class="contaner-user">
                @foreach ($usuarios as $usuario)
                    <div class="item-contaner" wire:click='selectThisUser({{$usuario->id}})'>
                        <div class="div-user @if($userSelect == $usuario->id) div-user-active @endif">
                            <img src="https://viciados.net/wp-content/uploads/2022/11/Naruto-Shippuden-Boruto-2023.webp" alt="usuario">
                            <div>
                                <h3>{{$usuario->apelido}}</h3>
                                <p>{{$usuario->status}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card-body" style="padding: 15px 0;">
                <div class="div-button-edit">
                    <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#ModalAddServices" style="height: 32px!important;">Adicionar </button>
                    <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#ModalEditServices" style="height: 32px!important;">Editar </button>
                </div>
                @foreach ($categorys as $category)
                    <h2 style="text-align: center;margin: 10px;">{{ $category->title }}</h2>
                    <ul id="sortable-list-{{ $category->id }}" class="sortable-list">
                        @foreach ($services as $service)
                            @if($service->id_categorias == $category->id)
                                <li data-id="{{ $service->id }}">
                                    <span>
                                        <div>
                                            <h2>{{ $service->title }}</h2>
                                        </div>
                                        <div style="font-size: 12px;opacity: 65%;">{{ $service->price}}€ - {{ $service->time }} min</div>
                                    </span>
                                    <div>
                                        <button class="btn btn-sm btn-gradient-primary btn-rounded btn-icon" style="width: 32px!important;height: 32px!important;"><i class="fa fa-pencil"></i></button>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endforeach
            </div>

        </div>
        <div class="modal fade" id="ModalEditServices" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Editar</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample">
                        <div class="form-group">
                            <label class="col-form-label">Categorias</label>
                            <select class="js-example-basic-single" style="width:100%">
                                @foreach ($categorys as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
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
                        </div> --}}
                    </form>
                </div>
                {{-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-gradient-primary">Enviar</button>
                </div> --}}
              </div>
            </div>
          </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function initializeSortable() {
                const categories = @json($categorys->map(function($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name
                    ];
                }));
                categories.forEach(category => {
                    const listElement = document.getElementById(`sortable-list-${category.id}`);

                    if (listElement) {
                        new Sortable(listElement, {
                            group: `category-${category.id}`,
                            animation: 150,
                            onEnd: function (evt) {
                                const order = Array.from(evt.from.children).map(item => item.dataset.id);
                                @this.call('updateOrder', order);
                            }
                        });
                    } else {
                        // console.error(`Elemento de lista não encontrado`);
                    }
                });
            }
            initializeSortable();
            document.addEventListener('click', function (event) {
                if (event.target.closest('.item-contaner')) {
                    setTimeout(() => {
                        initializeSortable();
                    }, 1000);
                }
            });
        });
    </script>

</div>

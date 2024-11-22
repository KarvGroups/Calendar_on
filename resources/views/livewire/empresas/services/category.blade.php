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
        {{-- @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif --}}

        <div class="card">
            <div class="contaner-user">
                @foreach ($usuarios as $usuario)
                    <div class="item-contaner" wire:click='selectThisUser({{$usuario->id}})'>
                        <div class="div-user @if($userSelect == $usuario->id) div-user-active @endif">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-Xx8AIsxmieshLptYYnziOIzxBgt39H5nyX9cWLTP_kK5f2QaXYu7SdQd7yNCohSuF6I&usqp=CAU" alt="usuario">
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
                    <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#ModalAddOptions" style="height: 32px!important;">Adicionar</button>
                </div>


                <div id="sortable-categories">
                    @foreach ($categorys as $category)
                        <div class="sortable-category" data-id="{{ $category->id }}">
                            <h2
                                style="text-align: center; margin: 10px; cursor: grab;"
                                wire:click.prevent="editCategory({{ $category->id }})"
                            >
                                {{ $category->title }}
                            </h2>
                            <ul id="sortable-list-{{ $category->id }}" class="sortable-list">
                                @foreach ($services as $service)
                                    @if($service->id_categorias == $category->id)
                                        <li data-id="{{ $service->id }}">
                                            <span>
                                                <div>
                                                    <h2>{{ $service->title }}</h2>
                                                </div>
                                                <div style="font-size: 12px; opacity: 65%;">{{ $service->price }}€ - {{ $service->time }} min</div>
                                            </span>
                                            <div>
                                                <button
                                                    class="btn btn-sm btn-gradient-primary btn-rounded btn-icon"
                                                    wire:click="editService({{ $service->id }})"
                                                >
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="modal fade" id="ModalEditServices" tabindex="-1" aria-labelledby="ModalEditServicesLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalEditServicesLabel">Editar Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Conteúdo do formulário -->
                        <form wire:submit.prevent="updateCategory">
                            <div class="form-group">
                                <label for="categoryTitle">Título</label>
                                <input
                                    type="text"
                                    id="categoryTitle"
                                    wire:model="selectedCategoryData.title"
                                    class="form-control"
                                />
                            </div>
                            <div class="form-group">
                                <label for="categoryStatus">Status</label>
                                <select
                                    id="categoryStatus"
                                    wire:model="selectedCategoryData.status"
                                    class="form-control"
                                >
                                    <option value="active">Ativo</option>
                                    <option value="inactive">Inativo</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button> --}}
                                <button type="button" wire:click="confirmDeleteCategory" class="btn btn-danger">Deletar Categoria</button>
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                                                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalAddOptions" tabindex="-1" aria-labelledby="ModalAddOptionsLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalAddOptionsLabel">Adicionar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p>O que você deseja adicionar?</p>
                        <div class="d-flex justify-content-around">
                            <button
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#ModalAddCategory"
                                data-bs-dismiss="modal"
                            >
                                Adicionar Categoria
                            </button>
                            <button
                                class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#ModalAddService"
                                data-bs-dismiss="modal"
                            >
                                Adicionar Serviço
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Modal para adicionar categoria -->
        <div class="modal fade" id="ModalAddCategory" tabindex="-1" aria-labelledby="ModalAddCategoryLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalAddCategoryLabel">Adicionar Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="addCategory">
                            <div class="form-group">
                                <label for="categoryTitle">Título</label>
                                <input
                                    type="text"
                                    id="categoryTitle"
                                    wire:model="newCategory.title"
                                    class="form-control"
                                />
                            </div>
                            <div class="form-group">
                                <label for="categoryStatus">Status</label>
                                <select
                                    id="categoryStatus"
                                    wire:model="newCategory.status"
                                    class="form-control"
                                >
                                    <option value="active">Ativo</option>
                                    <option value="inactive">Inativo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Salvar Categoria</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para adicionar serviço -->
        <div class="modal fade" id="ModalAddService" tabindex="-1" aria-labelledby="ModalAddServiceLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalAddServiceLabel">Adicionar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="addService">
                            <!-- Campo: Título -->
                            <div class="form-group">
                                <label for="serviceTitle">Título</label>
                                <input
                                    type="text"
                                    id="serviceTitle"
                                    wire:model="newService.title"
                                    class="form-control"
                                    placeholder="Digite o título do serviço"
                                />
                            </div>

                            <!-- Campo: Preço -->
                            <div class="form-group">
                                <label for="servicePrice">Preço (€)</label>
                                <input
                                    type="number"
                                    id="servicePrice"
                                    wire:model="newService.price"
                                    class="form-control"
                                    placeholder="Digite o preço"
                                />
                            </div>

                            <!-- Campo: Tempo -->
                            <div class="form-group">
                                <label for="serviceTime">Tempo (min)</label>
                                <input
                                    type="number"
                                    id="serviceTime"
                                    wire:model="newService.time"
                                    class="form-control"
                                    placeholder="Tempo em minutos"
                                />
                            </div>

                            <!-- Campo: Status -->
                            <div class="form-group">
                                <label for="serviceStatus">Status</label>
                                <select
                                    id="serviceStatus"
                                    wire:model="newService.status"
                                    class="form-control"
                                >
                                    <option value="active">Ativo</option>
                                    <option value="inactive">Inativo</option>
                                </select>
                            </div>

                            <!-- Campo: Categoria -->
                            <div class="form-group">
                                <label for="serviceCategory">Categoria</label>
                                <select
                                    id="serviceCategory"
                                    wire:model="newService.id_categorias"
                                    class="form-control"
                                >
                                    <option value="" selected>Selecione uma categoria</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Salvar Serviço</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalEditService" tabindex="-1" aria-labelledby="ModalEditServiceLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalEditServiceLabel">Editar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateService">
                            <!-- Campo: Título -->
                            <div class="form-group">
                                <label for="editServiceTitle">Título</label>
                                <input
                                    type="text"
                                    id="editServiceTitle"
                                    wire:model="selectedServiceData.title"
                                    class="form-control"
                                    placeholder="Digite o título do serviço"
                                />
                            </div>

                            <!-- Campo: Preço -->
                            <div class="form-group">
                                <label for="editServicePrice">Preço (€)</label>
                                <input
                                    type="number"
                                    id="editServicePrice"
                                    wire:model="selectedServiceData.price"
                                    class="form-control"
                                    placeholder="Digite o preço"
                                />
                            </div>

                            <!-- Campo: Tempo -->
                            <div class="form-group">
                                <label for="editServiceTime">Tempo (min)</label>
                                <input
                                    type="number"
                                    id="editServiceTime"
                                    wire:model="selectedServiceData.time"
                                    class="form-control"
                                    placeholder="Tempo em minutos"
                                />
                            </div>

                            <!-- Campo: Status -->
                            <div class="form-group">
                                <label for="editServiceStatus">Status</label>
                                <select
                                    id="editServiceStatus"
                                    wire:model="selectedServiceData.status"
                                    class="form-control"
                                >
                                    <option value="active">Ativo</option>
                                    <option value="inactive">Inativo</option>
                                </select>
                            </div>

                            <!-- Campo: Categoria -->
                            <div class="form-group">
                                <label for="editServiceCategory">Categoria</label>
                                <select
                                    id="editServiceCategory"
                                    wire:model="selectedServiceData.id_categorias"
                                    class="form-control"
                                >
                                    <option value="" selected>Selecione uma categoria</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button> --}}
                                <button type="button" wire:click="confirmDeleteService" class="btn btn-danger">Deletar Serviço</button>
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                                                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div wire:loading>
            <span>Carregando...</span>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('confirmDeleteService', function () {
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, deletar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteService');
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('confirmDeleteCategory', function () {
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, deletar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteCategory');
                    }
                });
            });
        });
        document.addEventListener('reloadPage', function () {
            location.reload();
        });

        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('openModal', function () {
                const modalElement = document.getElementById('ModalEditService');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('closeModalServicesEdit', function () {
                const modalElement = document.getElementById('ModalEditService');
                const modal = new bootstrap.Modal(modalElement);
                console.log("closeModalServicesEdit");

                modal.hide();

                modalElement.style.display = 'none';

                modalElement.classList.remove('show');

                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }

                document.body.classList.remove('modal-open');
            });
        });


        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('openModalEditServices', function () {
                const modalElement = document.getElementById('ModalEditServices');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('closeModalEditServices', function () {
                const modalElement = document.getElementById('ModalEditServices');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('closeModal', function (event) {
                const modalElement = document.getElementById(event.detail.modalId);
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const sortableCategories = document.getElementById('sortable-categories');

            if (sortableCategories) {
                new Sortable(sortableCategories, {
                    animation: 150,
                    handle: '.sortable-category h2', // Permite arrastar clicando no título da categoria
                    onEnd: function (evt) {
                        const order = Array.from(sortableCategories.children).map(item => item.dataset.id);
                        @this.call('updateCategoryOrder', order); // Envia a nova ordem para o Livewire
                    }
                });
            }
        });

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

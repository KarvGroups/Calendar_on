<div>
    <div class="card">
        <div class="card-body">
            <h2 class="text-lg font-semibold mb-4">Serviços</h2>
            <ul id="sortable-list" class="list-none">
                @foreach ($services as $service)
                    <li wire:key="service-{{ $service->id }}" data-id="{{ $service->id }}" class="border-b py-2">
                        <div class="flex justify-between">
                            <div>{{ $service->title }} - {{ $service->price }} € - {{ $service->time }} min</div>
                            <div>
                                <button wire:click="editService({{ $service->id }})" class="btn btn-primary bg-yellow-500 text-white px-1 py-1 rounded"><i class="fa fa-pencil"></i></button>
                                <button wire:click="deleteService({{ $service->id }})" class="btn btn-primary bg-red-500 text-white px-1 py-1 rounded"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>


            
            <button id="save-order-button" class="btn btn-primary bg-green-500 text-white px-3 py-2 rounded mt-4">
                Salvar Ordem
            </button>
        </div>
    </div>




<!-- Script SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sortableList = document.getElementById('sortable-list');
    let currentOrder = [];

    console.log("Iniciando SortableJS");

    if (sortableList) {
        Sortable.create(sortableList, {
            animation: 150,
            onEnd: function () {
                console.log("Itens reorganizados");
                currentOrder = Array.from(sortableList.children).map(item => item.getAttribute('data-id'));
            }
        });
    } else {
        console.log("Elemento sortable-list não encontrado");
    }

    document.getElementById('save-order-button').addEventListener('click', function () {
        if (typeof Livewire !== 'undefined' && typeof Livewire.emit === 'function') {
            console.log("Salvando ordem atual:", currentOrder);
            Livewire.emit('ServiceOrder', currentOrder);
        } else {
            console.error("Livewire não está disponível ou Livewire.emit não é uma função");
        }
    });
});

</script>

</div>

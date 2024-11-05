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
                                <button wire:click="editService({{ $service->id }})" class="btn btn-primary bg-yellow-500 text-white px-1 py-1 rounded">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button wire:click="deleteService({{ $service->id }})" class="btn btn-primary bg-red-500 text-white px-1 py-1 rounded">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Campo oculto para manter o `currentOrder` atualizado -->
            <input type="hidden" wire:model.defer="orderedIds" id="orderedIds">

            <button wire:click='ServiceOrder' class="btn btn-primary bg-green-500 text-white px-3 py-2 rounded mt-4">
                Salvar Ordem
            </button>
        </div>
    </div>

    <!-- Script SortableJS e SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sortableList = document.getElementById('sortable-list');
            let currentOrder = [];

            // Função para capturar a ordem inicial dos serviços ao carregar a página
            function setInitialOrder() {
                currentOrder = Array.from(sortableList.children).map(item => item.getAttribute('data-id'));
                const orderedIdsInput = document.getElementById('orderedIds');
                orderedIdsInput.value = currentOrder.join(','); // Salva como string de IDs separada por vírgula
                orderedIdsInput.dispatchEvent(new Event('input')); // Dispara o evento para Livewire
            }

            // Define a ordem inicial dos serviços
            setInitialOrder();

            if (sortableList) {
                Sortable.create(sortableList, {
                    animation: 150,
                    onEnd: function () {
                        // Atualiza `currentOrder` quando a ordem é alterada manualmente
                        currentOrder = Array.from(sortableList.children).map(item => item.getAttribute('data-id'));
                        const orderedIdsInput = document.getElementById('orderedIds');
                        orderedIdsInput.value = currentOrder.join(',');
                        orderedIdsInput.dispatchEvent(new Event('input'));
                    }
                });
            }
        });

        // Listener para exibir alerta de sucesso com SweetAlert
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

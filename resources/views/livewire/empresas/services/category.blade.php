<div>
    <div class="card">
        <div class="card-body">
            <h2 class="text-lg font-semibold mb-4">Serviços</h2>
            <ul id="sortable-list" class="list-none">
                @foreach ($services->where('order_int', 0) as $service)
                    <li wire:key="service-{{ $service->id }}" data-id="{{ $service->id }}" data-parent="0" class="border-b py-2">
                        <div class="flex justify-between">
                            <div>{{ $service->title }}</div>
                            <div>
                                <button wire:click="editService({{ $service->id }})" class="btn btn-primary bg-yellow-500 text-white px-1 py-1 rounded">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button wire:click="deleteService({{ $service->id }})" class="btn btn-primary bg-red-500 text-white px-1 py-1 rounded">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <ul class="sortable-sublist list-none pl-4" style="margin-left: 21px;">
                            @foreach ($services->where('order_int', $service->id) as $subService)
                                <li wire:key="sub-service-{{ $subService->id }}" data-id="{{ $subService->id }}" data-parent="{{ $service->id }}" class="border-b py-2">
                                    <div class="flex justify-between">
                                        <div>{{ $subService->title }} - {{ $subService->price }} € - {{ $subService->time }} min</div>
                                        <div>
                                            <button wire:click="editService({{ $subService->id }})" class="btn btn-primary bg-yellow-500 text-white px-1 py-1 rounded">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button wire:click="deleteService({{ $subService->id }})" class="btn btn-primary bg-red-500 text-white px-1 py-1 rounded">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const sortableList = document.getElementById('sortable-list');

    function setInitialOrder() {
        const currentOrder = Array.from(sortableList.children).map(item => item.getAttribute('data-id'));
        document.getElementById('orderedIds').value = currentOrder.join(',');
        document.getElementById('orderedIds').dispatchEvent(new Event('input'));
    }

    setInitialOrder();

    if (sortableList) {
        Sortable.create(sortableList, {
            group: 'services', // Permite arrastar entre listas
            animation: 150,
            fallbackOnBody: true, // Garante que o evento é disparado ao mover para fora
            onEnd: function (event) {
                const currentOrder = Array.from(sortableList.children).map(item => item.getAttribute('data-id'));
                document.getElementById('orderedIds').value = currentOrder.join(',');
                document.getElementById('orderedIds').dispatchEvent(new Event('input'));

                // Identifica o ID do serviço
                const serviceId = event.item.getAttribute('data-id');

                // Determina o novo ID do pai
                let newParentId;
                if (event.to === sortableList) {
                    // Item foi movido para o nível principal
                    newParentId = 0;
                    console.log(`Item ${serviceId} foi movido para o nível principal.`);
                    // Força o data-parent para 0
                    event.item.setAttribute('data-parent', '0');
                } else {
                    // Item está dentro de um subgrupo
                    const newParentElement = event.item.closest('.sortable-sublist');
                    newParentId = newParentElement ? newParentElement.closest('[data-id]').getAttribute('data-id') : 0;
                    console.log(`Item ${serviceId} foi movido para dentro do pai ${newParentId}.`);

                    // Atualiza o data-parent com o novo pai
                    event.item.setAttribute('data-parent', newParentId);
                }

                // Log para verificar o novo valor de `newParentId`
                console.log("Service ID:", serviceId, "New Parent ID:", newParentId, "Data-parent atualizado:", event.item.getAttribute('data-parent'));

                // Chama o método Livewire para atualizar a hierarquia no back-end
                @this.call('updateHierarchy', serviceId, newParentId);
            }
        });

        // Configura os sub-serviços para serem arrastáveis dentro do mesmo grupo
        document.querySelectorAll('.sortable-sublist').forEach(sublist => {
            Sortable.create(sublist, {
                group: 'services',
                animation: 150,
                fallbackOnBody: true, // Garante que o evento é disparado ao mover para fora
                onEnd: function (event) {
                    const serviceId = event.item.getAttribute('data-id');
                    const parentElement = event.to.closest('[data-id]');
                    const newParentId = parentElement ? parentElement.getAttribute('data-id') : 0;

                    // Força a atualização de `data-parent` ao mover para fora
                    if (newParentId === 0) {
                        event.item.setAttribute('data-parent', '0');
                    } else {
                        event.item.setAttribute('data-parent', newParentId);
                    }

                    console.log("Sub-lista: Service ID:", serviceId, "New Parent ID:", newParentId);

                    @this.call('updateHierarchy', serviceId, newParentId);
                }
            });
        });
    }
});





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

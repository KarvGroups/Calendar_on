<div>
    <style>
        .handle {
            cursor: move;
            display: flex;
            align-items: center;
        }
    </style>
    <div class="card">
        <div class="card-body">

            <h3 class="mt-6 text-lg font-semibold">Categorias</h3>
            <br>
            <table class="table table-striped">
                <tbody>
                @foreach ($GrupCategory as $category)
                    <tr class="border-b handle" data-id="{{ $category->id }}">
                        <th class="py-2" style="background:#dfbaff;">{{ $category->title }}</th>
                    </tr>
                    @if ($category->services->isNotEmpty())
                    <tr>
                        <td colspan="3" style="padding:0;padding-left: 30px;">
                            <table class="services-list bg-gray-100 my-1 w-full">
                                <tbody>
                                @foreach ($category->services as $service)
                                    <tr class="border-b handle" data-id="{{ $service->id }}">
                                        <td class="py-2" style="background:#dfbaff;">{{ $service->title }}</td>
                                        <td class="py-2 w-0" style="background:#dfbaff;">{{ $service->time }} - {{ $service->price }} €</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
   document.addEventListener('livewire:load', function () {
    // Configurar o Sortable para categorias
    const categoryTableBody = document.querySelector('table.table-striped tbody');

    if (categoryTableBody) {
        Sortable.create(categoryTableBody, {
            animation: 150,
            handle: '.handle', // Elemento para arrastar
            onEnd: function (event) {
                // Obter IDs das categorias na nova ordem
                const orderedIds = Array.from(categoryTableBody.children)
                    .filter(row => row.hasAttribute('data-id'))
                    .map(row => row.getAttribute('data-id'));

                // Enviar para o Livewire
                Livewire.emit('updateCategoryOrder', orderedIds);
            }
        });
    }

    // Configurar o Sortable para serviços
    document.querySelectorAll('table.services-list tbody').forEach(serviceList => {
        Sortable.create(serviceList, {
            group: 'services',
            animation: 150,
            handle: '.handle', // Elemento para arrastar
            onEnd: function (event) {
                // Obter IDs dos serviços na nova ordem
                const newOrder = Array.from(event.to.children)
                    .filter(row => row.hasAttribute('data-id'))
                    .map(row => row.getAttribute('data-id'));

                // Obter ID da nova categoria (caso os serviços tenham mudado de categoria)
                const newParentId = event.to.closest('tr[data-id]').getAttribute('data-id');

                // Enviar para o Livewire
                Livewire.emit('updateServiceOrder', newParentId, newOrder);
            }
        });
    });
});



    </script>


</div>

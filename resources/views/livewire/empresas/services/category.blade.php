<div>
    <style>
        #sortable-list li{
            background: #b788dbb0;
            color: white;
            padding: 5px 10px;
            margin: 10px 0;
        }
    </style>
    <div>
        <h1>Lista Arrastável</h1>
        <ul id="sortable-list">
            @foreach ($services as $service)
                <li data-id="{{ $service->id }}">{{ $service->title }}</li>
            @endforeach
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sortable = new Sortable(document.getElementById('sortable-list'), {
                animation: 150,
                onEnd: function (evt) {
                    const order = Array.from(evt.from.children).map(item => item.dataset.id);

                    @this.call('updateOrder', order);

                    Swal.fire({
                        title: 'Lista Atualizada!',
                        text: 'Nova ordem: ' + order.join(', '),
                        icon: 'success'
                    });
                }
            });
        });
    </script>
</div>

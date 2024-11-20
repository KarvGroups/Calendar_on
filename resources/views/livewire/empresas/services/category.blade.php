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
    </style>
    <div>
        <div class="card">
            <div class="card-body" style="padding: 30px 0;">
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                    console.error(`Elemento de lista não encontrado: #sortable-list-${category.id}`);
                }
            });
        });
    </script>
</div>

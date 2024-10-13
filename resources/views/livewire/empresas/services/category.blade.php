<div>
    <div class="card">
        <div class="card-body">
            <h2 class="text-lg font-semibold mb-4">Adicionar Nova Categoria</h2>

            <form wire:submit.prevent="createCategory">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Título da Categoria</label>
                    <input type="text" id="title" wire:model="title" class="mt-1 block w-full border rounded p-2" placeholder="Digite o nome da categoria">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">
                    Adicionar Categoria
                </button>
            </form>

            <h3 class="mt-6 text-lg font-semibold">Categorias</h3>

            <table class="table table-striped">
                <tbody>
                @forelse ($GrupCategory as $category)
                    <tr class="border-b table-secondary">
                        <th class="py-2">{{ $category->title }}</th>
                        <td class="py-2">{{ $category->status }}</td>
                        <td class="py-2" style="width: 0;">

                            <button wire:click="$set('selectedCategoryId', {{ $category->id }})" class="btn btn-primary bg-blue-500 text-white px-1 py-1 rounded"><i class="fa fa-plus"></i></button>

                            <button wire:click="editCategory({{ $category->id }})" class="btn btn-primary bg-yellow-500 text-white px-1 py-1 rounded"><i class="fa fa-pencil"></i></button>
                            <button wire:click="deleteCategory({{ $category->id }})" class="btn btn-primary bg-red-500 text-white px-1 py-1 rounded"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>

                    @if ($selectedCategoryId == $category->id && $isEditingCategory)
                        <tr class="border-b">
                            <td colspan="3" >
                                <form wire:submit.prevent="updateCategory" class="mt-2">
                                    <div class="mb-2">
                                        <input type="text" wire:model="title" class="w-full border p-2 rounded" placeholder="Atualizar Nome da Categoria"><br>
                                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mb-2">
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status da Categoria</label>
                                        <select id="status" wire:model="status" class="mt-1 block w-full border rounded p-2">
                                            <option value="active">Ativo</option>
                                            <option value="inactive">Inativo</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">Atualizar Categoria</button>
                                    <button type="button" wire:click="cancelEditCategory" class="btn btn-secondary bg-gray-500 text-white px-4 py-2 rounded">Fechar</button>
                                </form>

                            </td>
                        </tr>
                    @endif

                    @if ($selectedCategoryId == $category->id && !$isEditingCategory)
                    <tr class="border-b">
                        <td colspan="3">
                            <form wire:submit.prevent="createService" class="mt-2">
                                <div class="mb-2">
                                    <input type="text" wire:model="serviceTitle" placeholder="Nome do Serviço" class="w-full border p-2 rounded">
                                    @error('serviceTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-2">
                                    <input type="number" wire:model="servicePrice" placeholder="Preço" class="w-full border p-2 rounded">
                                    @error('servicePrice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-2">
                                    <input type="number" wire:model="serviceTime" placeholder="Tempo de Serviço" class="w-full border p-2 rounded">
                                    @error('serviceTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">Adicionar Serviço</button>
                                <button type="button" wire:click="cancelEditCategory" class="btn btn-secondary bg-gray-500 text-white px-4 py-2 rounded">Fechar</button>
                            </form>
                        </td>
                    </tr>
                    @endif

                    @if ($category->services->isNotEmpty())
                    <tr>
                        <td colspan="3" style="padding:0;padding-left: 30px;">
                            <table class="bg-gray-100 my-1 w-full">
                                <tbody>
                                @foreach ($category->services as $service)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $service->title }}</td>
                                        <td class="py-2">{{ $service->time }}</td>
                                        <td class="py-2">{{ $service->price }} €</td>
                                        <td class="py-2">{{ $service->status }}</td>

                                        <td class="py-2" style="width: 0;">
                                            <button wire:click="editService({{ $service->id }})" class="btn btn-primary bg-yellow-500 text-white px-1 py-1 rounded"><i class="fa fa-pencil"></i></button>
                                            <button wire:click="deleteService({{ $service->id }})" class="btn btn-primary bg-red-500 text-white px-1 py-1 rounded"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>

                                    @if ($selectedServiceId == $service->id && $isEditingService)
                                    <tr class="border-b">
                                        <td colspan="4">
                                            <form wire:submit.prevent="updateService" class="mt-2">
                                                <div class="mb-2">
                                                    <input type="text" wire:model="serviceTitle" placeholder="Nome do Serviço" class="w-full border p-2 rounded">
                                                    @error('serviceTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <input type="number" wire:model="servicePrice" placeholder="Preço" class="w-full border p-2 rounded">
                                                    @error('servicePrice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <input type="number" wire:model="serviceTime" placeholder="Tempo de Serviço" class="w-full border p-2 rounded">
                                                    @error('serviceTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Campo para editar o status do serviço -->
                                                <div class="mb-2">
                                                    <label for="status" class="block text-sm font-medium text-gray-700">Status do Serviço</label>
                                                    <select id="status" wire:model="status" class="mt-1 block w-full border rounded p-2">
                                                        <option value="active">Ativo</option>
                                                        <option value="inactive">Inativo</option>
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">Atualizar Serviço</button>
                                                <button type="button" wire:click="cancelEditService" class="btn btn-secondary bg-gray-500 text-white px-4 py-2 rounded">Fechar</button>
                                            </form>

                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-gray-500">Nenhuma categoria encontrada.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

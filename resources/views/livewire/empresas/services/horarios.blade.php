<div class="container mt-4">
    <h2 class="mb-4">Gerenciar Horários</h2>

    <!-- Formulário para adicionar um novo horário -->
    <form wire:submit.prevent="addSchedule" class="card p-4 mb-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="day_of_week" class="form-label">Dia da Semana:</label>
                <select wire:model="newSchedule.day_of_week" id="day_of_week" class="form-select">
                    <option value="">Selecione</option>
                    <option value="Segunda-feira">Segunda-feira</option>
                    <option value="Terça-feira">Terça-feira</option>
                    <option value="Quarta-feira">Quarta-feira</option>
                    <option value="Quinta-feira">Quinta-feira</option>
                    <option value="Sexta-feira">Sexta-feira</option>
                    <option value="Sábado">Sábado</option>
                    <option value="Domingo">Domingo</option>
                </select>
                @error('newSchedule.day_of_week') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="start_time" class="form-label">Horário de Início:</label>
                <input type="time" wire:model="newSchedule.start_time" id="start_time" class="form-control">
                @error('newSchedule.start_time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="end_time" class="form-label">Horário de Término:</label>
                <input type="time" wire:model="newSchedule.end_time" id="end_time" class="form-control">
                @error('newSchedule.end_time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Adicionar Horário</button>
    </form>

    <!-- Lista de horários existentes -->
    <div class="card">
        <div class="card-header">
            <h3>Horários Configurados</h3>
        </div>
        <ul class="list-group list-group-flush">
            @forelse ($workSchedules as $schedule)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $schedule['day_of_week'] }}</strong>:
                        {{ $schedule['start_time'] }} - {{ $schedule['end_time'] }}
                    </div>
                    <button wire:click="deleteSchedule({{ $schedule['id'] }})" class="btn btn-danger btn-sm">
                        Remover
                    </button>
                </li>
            @empty
                <li class="list-group-item text-center">Nenhum horário configurado.</li>
            @endforelse
        </ul>
    </div>
</div>

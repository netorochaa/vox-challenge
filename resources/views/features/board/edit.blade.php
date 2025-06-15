<x-app-layout>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Quadro</h3>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('board.update', $board->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nome do Quadro</label>
                    <input type="text" class="form-control" name="name" value="{{ $board->name }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar Quadro</button>
            </form>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Criar Categoria em {{ $board->name }}</h3>
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

            <form method="POST" action="{{ route('category.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome do Categoria</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <input type="hidden" name="board_id" value="{{ $board->id }}">
                </div>
                <button type="submit" class="btn btn-primary">Criar Categoria</button>
            </form>
    </div>
</x-app-layout>

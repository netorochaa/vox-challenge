<x-app-layout>
    <div class="d-flex align-items-baseline">
        <h2>{{ $board->name }}</h2>
        <a class="ms-auto btn btn-primary mb-3" href="{{ route('category.create', ['boardId' => $board->id]) }}">
            Nova Categoria
        </a>
    </div>

    <div class="container">
        <div class="row gap-3" id="board-categories">
            <div class="col border rounded-2 p-4">
                oi
            </div>
            <div class="col border rounded-2 p-4">
                oi
            </div>
            <div class="col border rounded-2 p-4">
                oi
            </div>
        </div>
    </div>

    @push('scripts')
        <script>

        </script>
    @endpush
</x-app-layout>

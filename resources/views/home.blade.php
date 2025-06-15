<x-app-layout>
    <div class="d-flex align-items-baseline">
        <h2>Quadros</h2>
        <a class="ms-auto btn btn-primary mb-3" href="{{ route('board.create') }}">
            Novo Quadro
        </a>
    </div>

    <div class="d-none card" id="card-board">
        <div class="card-body">
            <table class="table" id="board-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Data de criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                setLoadingSpinner(true);

                $.ajax({
                    url: '/api/board',
                    type: 'GET',
                    success: function(response) {
                        var tbody = $('#board-table tbody');
                        tbody.empty();

                        $.each(response.data, function(index, board) {
                            var row = '<tr>' +
                                    '<td>' + board.id + '</td>' +
                                    '<td>' + board.name + '</td>' +
                                    '<td>' + board.created_at + '</td>' +
                                    '<td>' +
                                        '<a class="btn btn-outline-info btn-sm" href="board/'+ board.id + '/edit">Editar</a>' +
                                        '<a class="mx-2 btn btn-outline-secondary btn-sm" href="board/'+ board.id + '">Acessar</a>' +
                                        '<form action="/board/' + board.id + '/delete" method="POST" style="display:inline;">' +
                                            '@csrf' +
                                            '@method("DELETE")' +
                                            '<button type="submit" class="btn btn-outline-danger btn-sm">Remover</button>' +
                                        '</form>' +
                                    '</td>' +
                                    '</tr>';
                            tbody.append(row);
                        });

                        if (response.data.length === 0) {
                            tbody.append('<tr><td colspan="4" class="text-center">Nenhum quadro encontrado</td></tr>');
                        }
                    },
                    error: function() {
                        console.error('Erro ao carregar quadros');
                    },
                    complete: function() {
                        setLoadingSpinner(false);
                    }
                });
            });

            function setLoadingSpinner(show) {
                if (show) {
                    $('#card-loading').removeClass('d-none');
                    $('#card-board').addClass('d-none');
                } else {
                    $('#card-loading').addClass('d-none');
                    $('#card-board').removeClass('d-none');
                }
            }
        </script>
    @endpush
</x-app-layout>

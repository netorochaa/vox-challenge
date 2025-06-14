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
            var edit

            $(document).ready(function() {
                setLoadingSpinner(true);

                $.ajax({
                    url: '/api/board',
                    type: 'GET',
                    success: function(response) {
                        var tbody = $('#board-table tbody');
                        tbody.empty();

                        $.each(response.data, function(index, user) {
                            var row = '<tr>' +
                                    '<td>' + user.id + '</td>' +
                                    '<td>' + user.name + '</td>' +
                                    '<td>' + user.created_at + '</td>' +
                                    '<td> <a class="btn btn-outline-info btn-sm" href="board/'+ user.id + '/edit">Acessar</a> </td>' +
                                    '</tr>';
                            tbody.append(row);
                        });
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

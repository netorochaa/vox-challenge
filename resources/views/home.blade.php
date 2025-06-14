<x-app-layout>
    <div class="d-flex align-items-baseline">
        <h2>Quadros</h2>
        <a class="ms-auto btn btn-primary mb-3" href="{{ route('board.create') }}">
            Novo Quadro
        </a>
    </div>

    <div class="d-none card" id="card-board">
        <div class="card-body">
            <table id="board-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Data de criação</th>
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

                // $.ajax({
                //     url: '/api/users-options',
                //     type: 'GET',
                //     success: function(response) {
                //         $('#user-select').html(response);
                //     },
                //     error: function() {
                //         console.error('Erro ao carregar opções');
                //     }
                // });
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

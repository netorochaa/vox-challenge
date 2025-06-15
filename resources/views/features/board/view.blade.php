<x-app-layout>
    <div class="d-flex align-items-baseline">
        <h2>{{ $board->name }}</h2>
        <a class="ms-auto btn btn-primary mb-3" href="{{ route('category.create', ['boardId' => $board->id]) }}">
            Nova Categoria
        </a>
    </div>

    <div class="container">
        <div class="row gap-3" id="board-categories">
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="taskStoreModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" >Criar task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="taskFormErrors">
                    </div>
                    <form id="taskStoreForm">
                        @csrf
                        <div class="mb-3">
                            <label for="taskName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="taskName" name="name" required>
                        </div>
                        <input type="hidden" name="category_id" id="categoryId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="submitTask()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const boardId = @json($board->id);

            document.getElementById('taskStoreModal').addEventListener('hidden.bs.modal', function () {
                $('#taskStoreForm')[0].reset();
                $('#taskFormErrors').empty();
                $('#taskFormErrors').hide();
            });

            $(document).ready(function() {
                initPage();
            });

            async function initPage() {
                await fetchCategories();
            }

            async function fetchCategories() {
                return new Promise((resolve, reject) => {
                    setLoadingSpinner(true);

                    $.ajax({
                        url: '/api/category?board_id=' + boardId,
                        type: 'GET',
                        success: function(response) {
                            const categories = response.data;
                            const container = $('#board-categories');
                            container.empty();

                            if (categories.length === 0) {
                                container.append('<div class="col-12 text-center">Nenhuma categoria encontrada.</div>');
                                return;
                            }

                            categories.forEach(category => {
                                const categoryCard = `
                                    <div class="col border rounded-2 p-4" data-category-id="${category.id}">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <h5>${category.name}</h5>
                                            <button
                                                class="btn btn-outline-secondary btn-sm"
                                                onclick="setCategoryToTask(${category.id})"
                                                data-bs-toggle="modal"
                                                data-bs-target="#taskStoreModal"
                                            >
                                                + Task
                                            </button>
                                        </div>
                                    </div>
                                `;
                                container.append(categoryCard);
                                fetchTasksByCategory(category.id);
                            });

                            resolve();
                        },
                        error: function() {
                            console.error('Erro ao carregar quadros');
                            reject();
                        },
                        complete: function() {
                            setLoadingSpinner(false);
                        }
                    });
                });
            }

            function fetchTasksByCategory(categoryId) {
                $.ajax({
                    url: `/api/category/${categoryId}/task`,
                    type: 'GET',
                    success: function(response) {
                        const tasks = response.data;
                        const container = $('#board-categories');
                        const categoryCol = container.find(`[data-category-id="${categoryId}"]`);
                        container.find(`#category-tasks-list-${categoryId}`).remove();

                        if (categoryCol.length) {
                            if (!categoryCol.find(`#category-tasks-list-${categoryId}`).length) {
                                categoryCol.append(`<div class="mt-3" id="category-tasks-list-${categoryId}"></div>`);
                            }
                        }

                        tasks.forEach(task => {
                            if (categoryCol.length) {
                                categoryCol.find(`#category-tasks-list-${categoryId}`).append(`
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h5 class="card-title">${task.name}</h5>
                                            <p class="card-text">Criado em: ${task.created_at}</p>
                                        </div>
                                    </div>
                                `);
                            }
                        });
                    },
                    error: function() {
                        console.error('Erro ao carregar tarefas');
                    },
                });
            }

            function submitTask() {
                const form = $('#taskStoreForm');
                const formData = form.serialize();
                const categoryId = $('#categoryId').val();

                $.ajax({
                    url: '/api/task',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#taskStoreModal').modal('hide');
                        fetchTasksByCategory(categoryId);
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        showErrors(errors);
                    }
                });
            }

            function showErrors(errors) {
                const errorList = $('<ul class="list-group list-group-flush"></ul>');
                for (const field in errors) {
                    errors[field].forEach(error => {
                        errorList.append(`<li class="list-group-item text-danger">${error}</li>`);
                    });
                }
                $('#taskFormErrors').html(errorList);
                $('#taskFormErrors').show();
            }

            function setCategoryToTask(categoryId) {
                $('#categoryId').val(categoryId);
            }

            function setLoadingSpinner(show) {
                if (show) {
                    $('#card-loading').removeClass('d-none');
                    $('#board-categories').hide();
                } else {
                    $('#card-loading').addClass('d-none');
                    $('#board-categories').show();
                }
            }
        </script>
    @endpush
</x-app-layout>

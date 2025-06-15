<?php

use App\Models\Category;
use App\Models\Task;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('can return tasks for a category', function () {
    $category = Category::factory()->create();
    $tasks = Task::factory(3)->for($category)->create();
    $tasks = $tasks->sortBy('order');

    $response = $this->get(route('tasks.index', ['categoryId' => $category->id]));

    $response->assertOk();
    $response->assertJsonCount(3, 'data');
    $response->assertJsonFragment(['id' => $tasks[0]->id]);
    $response->assertJsonFragment(['id' => $tasks[1]->id]);
    $response->assertJsonFragment(['id' => $tasks[2]->id]);
});

it('can create a task', function () {
    $category = Category::factory()->create();
    $taskData = [
        'name'        => 'New Task',
        'category_id' => $category->id,
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);

    $response->assertCreated();
    $response->assertJsonFragment($taskData);
    $this->assertDatabaseHas('tasks', $taskData);
});

it('must create the task at the end of the category order', function () {
    $expectedLastOrder = 3;

    $category = Category::factory()->create();
    Task::factory(2)->for($category)->create();

    $taskData = [
        'name'        => 'New Task',
        'category_id' => $category->id,
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);

    $response->assertCreated();
    $response->assertJsonFragment($taskData);
    $this->assertDatabaseHas('tasks', [
        'name'        => 'New Task',
        'category_id' => $category->id,
        'order'       => $expectedLastOrder
    ]);
});

it('can move tasks between categories', function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();
    $task1 = Task::factory()->for($category1)->create(['order' => 1]);
    $task2 = Task::factory()->for($category1)->create(['order' => 2]);

    $moveData = [
        'data' => [
            ['task_id' => $task1->id, 'category_id' => $category2->id, 'order' => 1],
            ['task_id' => $task2->id, 'category_id' => $category2->id, 'order' => 2],
        ]
    ];

    $response = $this->postJson(route('tasks.move'), $moveData);

    $response->assertOk();
    $response->assertJson(['message' => 'Tasks movidas com sucesso']);

    $this->assertDatabaseHas('tasks', [
        'id'          => $task1->id,
        'category_id' => $category2->id,
        'order'       => 1
    ]);
    $this->assertDatabaseHas('tasks', [
        'id'          => $task2->id,
        'category_id' => $category2->id,
        'order'       => 2
    ]);
});

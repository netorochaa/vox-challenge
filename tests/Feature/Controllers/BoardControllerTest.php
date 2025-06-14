<?php

use App\Models\Board;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('shows the create board view', function () {
    $response = $this->get(route('board.create'));
    $response->assertViewIs('features.board.create');
});

it('stores a new board and redirects with success', function () {
    $data = [
        'name' => 'Test Board',
    ];

    $response = $this->post(route('board.store'), $data);

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('success', 'Board created successfully');
    $this->assertDatabaseHas('boards', ['name' => 'Test Board']);
});

it('shows the edit board view with board data', function () {
    $board = Board::factory()->create();

    $response = $this->get(route('board.edit', ['id' => $board->id]));

    $response->assertOk();
    $response->assertViewIs('features.board.edit');
    $response->assertViewHas('board', fn ($viewBoard) => $viewBoard->id === $board->id);
});

it('updates a board and redirects with success', function () {
    $board = Board::factory()->create(['name' => 'Old Name']);

    $data = [
        'name' => 'Updated Name',
    ];

    $response = $this->put(route('board.update', ['id' => $board->id]), $data);

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('success', 'Board updated successfully');
    $this->assertDatabaseHas('boards', ['id' => $board->id, 'name' => 'Updated Name']);
});

it('shows the board view with board data', function () {
    $board = Board::factory()->create();

    $response = $this->get("/board/{$board->id}");

    $response->assertOk();
    $response->assertViewIs('features.board.view');
    $response->assertViewHas('board', fn ($viewBoard) => $viewBoard->id === $board->id);
});

it('can validate board unique name on store', function () {
    $board = Board::factory()->create(['name' => 'Unique Board Name']);

    $data = [
        'name' => 'Unique Board Name',
    ];

    $response = $this->post(route('board.store'), $data);

    $response->assertSessionHasErrors('name');
    $this->assertDatabaseCount('boards', 1);
});

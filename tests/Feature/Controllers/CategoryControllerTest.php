<?php

use App\Models\Board;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('create screen can be rendered for a board', function () {
    $board = Board::factory()->create();

    $response = $this->get(route('category.create', ['boardId' => $board->id]));

    $response->assertStatus(200);
    $response->assertViewIs('features.board.category.create');
    $response->assertViewHas('board', fn ($viewBoard) => $viewBoard->id === $board->id);
});

test('category can be stored and redirects with success', function () {
    $board = Board::factory()->create();

    $data = [
        'name'     => 'Test Category',
        'board_id' => $board->id,
    ];

    $response = $this->post(route('category.store'), $data);

    $response->assertRedirect(route('board.view', $board->id));

    $this->assertDatabaseHas('categories', [
        'name'     => 'Test Category',
        'board_id' => $board->id,
    ]);
});

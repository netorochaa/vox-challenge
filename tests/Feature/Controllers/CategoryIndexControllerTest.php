<?php

use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('can validate board_id is required', function () {
    $response = $this->get('/api/category');

    $response->assertStatus(404);
    $response->assertSeeText('Not Found');
});

it('returns categories for a given board', function () {
    $board = \App\Models\Board::factory()->create();
    $categories = \App\Models\Category::factory()->count(3)->create(['board_id' => $board->id]);

    $response = $this->get('/api/category?board_id=' . $board->id);

    $response->assertOk();
    $response->assertJsonCount(3, 'data');
    $response->assertJsonFragment(['id' => $categories[0]->id]);
    $response->assertJsonFragment(['id' => $categories[1]->id]);
    $response->assertJsonFragment(['id' => $categories[2]->id]);
});

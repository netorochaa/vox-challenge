<?php

use App\Models\Board;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('returns boards in descending order of creation', function () {
    $this->actingAs(User::factory()->create());

    $board1 = Board::factory()->create(['created_at' => now()->subDays(2)]);
    $board2 = Board::factory()->create(['created_at' => now()->subDay()]);
    $board3 = Board::factory()->create(['created_at' => now()]);

    $response = $this->get('/api/board');

    $response->assertOk();

    $response->assertJson(
        fn (AssertableJson $json) => $json->has('data', 3)
            ->has(
                'data.0',
                fn ($json) => $json->where('id', $board3->id)
                    ->etc()
            )
            ->has(
                'data.1',
                fn ($json) => $json->where('id', $board2->id)
                    ->etc()
            )
            ->has(
                'data.2',
                fn ($json) => $json->where('id', $board1->id)
                    ->etc()
            )
    );
});

it('returns empty collection if no boards exist', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->get('/api/board');

    $response->assertOk();
    $response->assertJson(
        fn (AssertableJson $json) => $json->where('data', [])
    );
});

<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shoult_list_only_scoped_user_stocks()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Stock::factory()->count(7)->create();
        $stock = Stock::factory(['user_id' => $user->id])->create();
        $this->assertEquals(1, Stock::count());
        $this->assertEquals($stock->id, Stock::first()->id);
    }
}

<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Domains\Styles\Dto\Style;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InternalStylesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_validate_style_create()
    {
//        $data = [];
//        $user = User::factory()->create();
//
//        Sanctum::actingAs($user);
//        $this->postJson(route('style.internal.store'), $data)
//            ->assertJsonFragment([
//                'errors' => [
//                    'code' => ['Please enter a style code'],
//                    'name' => ['Please enter a style name'],
//                    'category_ids' => ['Please select a category'],
//                    'type_id' => ['Please select a type'],
//                    ''
//                ]
//            ]);
    }

    public function test_validate_category_ids()
    {
        $data = [
            ''
        ];
    }
}

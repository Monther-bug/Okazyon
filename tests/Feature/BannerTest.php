<?php

namespace Tests\Feature;

use App\Models\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BannerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_multiple_active_banners()
    {
        Storage::fake('public');

        $banner1 = Banner::factory()->create([
            'is_active' => true,
            'title' => 'Banner 1'
        ]);

        $banner2 = Banner::factory()->create([
            'is_active' => true,
            'title' => 'Banner 2'
        ]);

        $this->assertEquals(2, Banner::where('is_active', true)->count());
        $this->assertTrue($banner1->fresh()->is_active);
        $this->assertTrue($banner2->fresh()->is_active);
    }

    public function test_api_returns_all_active_banners()
    {
        Storage::fake('public');

        Banner::factory()->create(['is_active' => true, 'title' => 'Active 1']);
        Banner::factory()->create(['is_active' => true, 'title' => 'Active 2']);
        Banner::factory()->create(['is_active' => false, 'title' => 'Inactive']);

        $response = $this->getJson('/api/v1/home/banner');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }
}

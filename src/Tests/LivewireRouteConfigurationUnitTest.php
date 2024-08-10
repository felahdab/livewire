<?php

namespace Livewire\Tests;

use Error;
use Exception;
use Illuminate\Routing\Route;
use Tests\TestCase;

class LivewireRouteConfigurationUnitTest extends TestCase
{
    public function test_livewire_default_update_route_is_livewire_update(): void
    {
        $route = $this->getRouteByName('livewire.update');

        $this->assertTrue($route->uri() == 'livewire/update');
    }

    public function test_livewire_default_livewire_upload_file_route_is_livewire_upload(): void
    {
        $route = $this->getRouteByName('livewire.upload-file');

        $this->assertTrue($route->uri() == 'livewire/upload-file');
    }

    public function test_livewire_default_livewire_file_preview_route_is_livewire_preview_file(): void
    {
        $route = $this->getRouteByName('livewire.preview-file');

        $this->assertTrue($route->uri() == 'livewire/preview-file/{filename}');
    }

    public function test_livewire_default_livewire_asset_route_is_livewire_livewire_js(): void
    {
        $route = $this->getRouteByName('livewire.assetjs');

        $this->assertTrue($route->uri() == 'livewire/livewire.js');
    }

    // public function test_livewire_default_livewire_map_asset_route_is_livewire_livewire_js(): void
    // {
    //     $route = $this->getRouteByName('livewire.assetjsmap');

    //     $this->assertTrue($route->uri() == 'livewire/livewire.min.js.map');
    // }

    protected function getRouteByUri(string $uri): Route
    {
        $route = collect(\Illuminate\Support\Facades\Route::getRoutes())
            ->firstWhere(fn(Route $route) => $route->uri() === $uri);

        if ($route === null) {
            $this->fail("Route '$uri' not found.");
        }

        return $route;
    }

    protected function getRouteByName(string $name): Route
    {
        $route = collect(\Illuminate\Support\Facades\Route::getRoutes())
            ->firstWhere(fn(Route $route) => $route->getName() === $name);

        if ($route === null) {
            $this->fail("Route '$name' not found.");
        }

        return $route;
    }

}

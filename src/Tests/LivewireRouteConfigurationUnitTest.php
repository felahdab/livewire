<?php

namespace Livewire\Tests;

use Error;
use Exception;
use Illuminate\Routing\Route;
use Tests\TestCase;

use Livewire\Mechanisms\HandleRequests\HandleRequests;

class LivewireRouteConfigurationUnitTest extends TestCase
{
    /* These first tests check the default setup of livewire routes. 
    */
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

    public function test_livewire_default_livewire_asset_route_is_livewire_livewire_min_js(): void
    {
        $route = $this->getRouteByName('livewire.assetjs');

        $this->assertTrue($route->uri() == 'livewire/livewire.min.js');
    }

    // public function test_livewire_default_livewire_map_asset_route_is_livewire_livewire_js(): void
    // {
    //     $route = $this->getRouteByName('livewire.assetjsmap');

    //     $this->assertTrue($route->uri() == 'livewire/livewire.min.js.map');
    // }

    /* These tests check the new functionnalities for route registration
    */
    public function test_livewire_default_update_route_is_respecting_config(): void
    {
        // We change the configuration
        config()->set('livewire.routes.livewire_update.url', 'custom/livewire/update/route');
        // We register the update route
        app(HandleRequests::class)->setUpdateRoute(function ($handle, $url, $middlewares) {
            return \Illuminate\Support\Facades\Route::post($url, $handle)->middleware($middlewares);
        });

        // We check that the new route is taken into account.
        $route = $this->getRouteByName('livewire.update');
        dump(collect(\Illuminate\Support\Facades\Route::getRoutes()));

        $this->assertTrue($route->uri() == 'custom/livewire/update/route');
    }

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

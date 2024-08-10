<?php

namespace Livewire\Tests;

use Error;
use Exception;
use Illuminate\Routing\Route;
use Tests\TestCase;

class LivewireRouteConfigurationTest extends TestCase
{
    public function test_livewire_default_routes_are_untouched(): void
    {
        $update_route = $this->getRouteByName('livewire.update');

        $this->assertTrue($update_route->uri() === '/livewire/update');
    }
    // public function test_livewire_script_route_is_cacheable(): void
    // {
    //     $route = $this->getRoute('livewire/livewire.min.js');

    //     $this->cacheRoute($route, 'Livewire\Mechanisms\FrontendAssets\FrontendAssets@returnJavaScriptAsFile', "Failed to cache route 'livewire/livewire.js'");
    // }

    // public function test_livewire_update_route_is_cacheable(): void
    // {
    //     $route = $this->getRoute('livewire/update');

    //     $this->cacheRoute($route, 'Livewire\Mechanisms\HandleRequests\HandleRequests@handleUpdate', "Failed to cache route 'livewire/update'");
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

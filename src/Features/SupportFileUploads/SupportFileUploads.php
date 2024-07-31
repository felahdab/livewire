<?php

namespace Livewire\Features\SupportFileUploads;

use function Livewire\on;
use Livewire\ComponentHook;
use Illuminate\Support\Facades\Route;
use Facades\Livewire\Features\SupportFileUploads\GenerateSignedUploadUrl as GenerateSignedUploadUrlFacade;

class SupportFileUploads extends ComponentHook
{
    static function provide()
    {
        if (app()->runningUnitTests()) {
            // Don't actually generate S3 signedUrls during testing.
            // Can't use ::partialMock because it's not available in older versions of Laravel.
            $mock = \Mockery::mock(GenerateSignedUploadUrl::class);
            $mock->makePartial()->shouldReceive('forS3')->andReturn([]);
            GenerateSignedUploadUrlFacade::swap($mock);
        }

        app('livewire')->propertySynthesizer([
            FileUploadSynth::class,
        ]);

        on('call', function ($component, $method, $params, $addEffect, $earlyReturn) {
            if ($method === '_startUpload') {
                if (! method_exists($component, $method)) {
                    throw new MissingFileUploadsTraitException($component);
                }
            }
        });

        $url = config('livewire.routes.livewire_upload-file.url');
        $middlewares = config('livewire.routes.livewire_upload-file.middlewares');

        Route::post($url, [FileUploadController::class, 'handle'])
            ->name('livewire.upload-file')
            ->middleware( $middlewares);

        $url = config('livewire.routes.livewire_preview-file.url');
        $middlewares = config('livewire.routes.livewire_preview-file.middlewares');

        Route::get($url, [FilePreviewController::class, 'handle'])
            ->name('livewire.preview-file')
            ->middleware($middlewares);
    }
}

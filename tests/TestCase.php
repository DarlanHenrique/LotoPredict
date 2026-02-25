<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Vite;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Esta é a forma mais robusta de silenciar o Vite nos testes
        // sem depender do trait 'WithoutVite' ou do método 'fake()'
        $this->withoutVite();
    }

    /**
     * Helper manual para desativar o Vite se o trait falhar
     */
    protected function withoutVite()
    {
        $this->app->instance(\Illuminate\Foundation\Vite::class, new class extends \Illuminate\Foundation\Vite {
            public function __invoke($entrypoints, $buildDirectory = null) { return ''; }
            public function asset($asset, $buildDirectory = null) { return ''; }
        });
    }
}
<?php

use Illuminate\Support\Facades\Vite;

beforeEach(function () {
    $this->hotFile = storage_path('framework/testing/vite-hot-test');
    file_put_contents($this->hotFile, 'http://127.0.0.1:5173');
    Vite::useHotFile($this->hotFile);
});

afterEach(function () {
    @unlink($this->hotFile);
});

test('local development allows the running vite dev server in the content security policy', function () {
    $csp = $this->get('/')->assertOk()->headers->get('Content-Security-Policy');

    expect($csp)->toContain("script-src 'self' 'unsafe-inline' 'unsafe-eval' http://127.0.0.1:5173 ws://127.0.0.1:5173;")
        ->and($csp)->toContain("connect-src 'self' http://127.0.0.1:5173 ws://127.0.0.1:5173;");
});

test('production never allows the vite dev server even if a hot file is left behind', function () {
    app()->detectEnvironment(fn () => 'production');

    $csp = $this->get('/')->headers->get('Content-Security-Policy');

    expect($csp)->not->toContain('5173')
        ->and($csp)->toContain("script-src 'self' 'unsafe-inline' 'unsafe-eval';");
});

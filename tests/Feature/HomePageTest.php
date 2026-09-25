<?php

test('homepage loads successfully with brand name and key sections', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('Gentriiq Safaris & Tours')
        ->assertSee('+254 717 838061')
        ->assertSee('+254 720 115305')
        ->assertSee('Plan My Safari')
        ->assertSee('Featured Safari Packages')
        ->assertSee('Iconic Safari Destinations');
});

test('homepage includes primary booking whatsapp contact link', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('https://wa.me/254717838061', false);
});

test('homepage includes a theme toggle button', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('Switch to dark mode')
        ->assertSee('Switch to light mode');
});

test('homepage title leads with the Gentriiq brand name', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('<title>Gentriiq Safaris &amp; Tours — Authentic East African Safaris &amp; Adventures</title>', false)
        ->assertSee('<meta property="og:title"'."\n".'        content="Gentriiq Safaris &amp; Tours — Authentic East African Safaris &amp; Adventures">', false)
        ->assertDontSee('<title>Authentic East African Safaris', false);
});

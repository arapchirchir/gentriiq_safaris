<?php

test('about page loads with story, values, and calls to action', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('<title>About Us | Gentriiq Safaris &amp; Tours</title>', false)
        ->assertSee('Our Story')
        ->assertSee('Our Mission & Values', false)
        ->assertSee('Conservation & Community', false)
        ->assertSee(route('plan.create'), false)
        ->assertSee('https://wa.me/254717838061', false)
        ->assertSee('tel:+254717838061', false);
});

test('about page hides team and credentials sections until real entries are added', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertDontSee('Meet Our Team')
        ->assertDontSee('Licensed & Trusted', false);
});

test('navigation links work from pages other than the homepage', function () {
    $response = $this->get(route('about'))->assertOk();

    foreach (['safaris', 'destinations', 'experiences', 'why-gentriiq', 'contact'] as $section) {
        $response->assertSee('href="'.route('home').'#'.$section.'"', false);
    }

    $response->assertSee('href="'.route('about').'"', false)
        ->assertDontSee('href="#about"', false)
        ->assertDontSee('href="#safaris"', false);
});

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet() {
        $this->get('/rnd')->assertStatus(200)->assertSeeText('Hello Randi Febriadi');
    }

    public function testRedirect() {
        $this->get('/youtube')->assertRedirect('/rnd');
    }

    public function testFallback() {
        $this->get('/youtube1')->assertSeeText('404');
    }

    public function testRouteParameter() {
        $this->get('/products/14')->assertSeeText('Product : 14');

        $this->get('/products/1')->assertSeeText('Product : 1');

        $this->get('/products/12/items/4')->assertSeeText('Product : 12, Item : 4');
    }

    public function testRouteParameterRegex(){
        $this->get('/categories/14')->assertSeeText('Category 14');

        $this->get('/categories/randi')->assertSeeText('404 by Randi Febriadi');
    }

    public function testRouteOptionalParameter(){
        $this->get('/users/')->assertSeeText('User : 404');

        $this->get('/users/8293')->assertSeeText('User : 8293');
    }

    public function testRouteConflict(){
        $this->get('/conflict/randi')->assertSeeText('Conflict Randi Febriadi');

        $this->get('/conflict/tes')->assertSeeText('Conflict tes');
    }

    public function testNamedRoute(){
        $this->get('/produk/090809')->assertSeeText('products/090809');

        $this->get('/produk-redirect/8798')->assertRedirect('products/8798');
    }
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class URLGenerationTest extends TestCase
{
    public function testURLCurrent() {
        $this->get('/url/current?name=Randi')->assertSeeText('/url/current?name=Randi');
    }

    public function testNamed() {
        $this->get('/url/named')->assertSeeText('/redirect/name/Randi');
    }

    public function testAction() {
        $this->get('/url/action')->assertSeeText('/form');
    }
}
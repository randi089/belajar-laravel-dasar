<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView() {
        $this->get('/hello')->assertSeeText('Randi');
    }

    public function testNested() {
        $this->get('/world')->assertSeeText('Programmer');
    }

    public function testTemplate() {
        $this->view('hello.world', ['name' => 'Randi Programmer'])->assertSeeText('Programmer');
    }
}
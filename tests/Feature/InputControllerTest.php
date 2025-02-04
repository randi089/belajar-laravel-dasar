<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput() {

        $this->get('/input/hello?name=Randi')->assertSeeText('Hello Randi');
        $this->post('/input/hello', ['name' => 'Randi'])->assertSeeText('Hello Randi');
        
    }

    public function testNestedInput() {

        $this->post('/input/hello/first', ['name' => [
            'first' => 'Randi']])->assertSeeText('Hello Randi');
        
    }

    public function testInputAll() {

        $this->post('/input/hello/input', ['name' => [
            'first' => 'Randi',
            'last' => 'Febriadi'
            ]])->assertSeeText('name')->assertSeeText('first')->assertSeeText('Randi')->assertSeeText('last')->assertSeeText('Febriadi');
        
    }

    public function testInputArray() {

        $this->post('/input/hello/array', ['products' => [
            [
                'name' => 'Apple Mac Book Pro',
                'price' => 30000000
            ],
            [
                'name' => 'Samsung Galaxy S10',
                'price' => 15000000
            ]
            ]])->assertSeeText('Apple Mac Book Pro')->assertSeeText('Samsung Galaxy S10');
        
    }
    
    public function testInputType() {

        $this->post('/input/type', [
            'name' => 'Randi',
            'married' => 'true',
            'birth_date' => '1999-02-03'
        ])->assertSeeText('Randi')->assertSeeText('true')->assertSeeText('1999-02-03');
        
    }
}
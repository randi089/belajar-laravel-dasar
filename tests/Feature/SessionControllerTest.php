<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession() {
        $this->get('/session/create')->assertSeeText('OK')->assertSessionHas('userId', 'randi')->assertSessionHas('isMember', 'true');
    }

    public function testGetSession(){
    $this->withSession([
        'userId' => 'randi',
        'isMember' => 'true'
    ])->get('/session/get')->assertSeeText('randi')->assertSeeText('true');
    }

    public function testGetSessionFiled(){
        $this->withSession([])->get('/session/get')->assertSeeText('guest')->assertSeeText('false');
    }
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
  public function testConfig() {
    $firstName = config("contoh.author.first");
    $lastName = config("contoh.author.last");
    $email = config("contoh.email");
    $web = config("contoh.web");

    self::assertEquals('Randi', $firstName);
    self::assertEquals('Febriadi', $lastName);
    self::assertEquals('randifebriadi@gmail.com', $email);
    self::assertEquals('https://www.github.com/randi089', $web);
  }
}
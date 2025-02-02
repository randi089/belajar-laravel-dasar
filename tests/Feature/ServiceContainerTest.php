<?php

namespace Tests\Feature;

use App\Data\Foo;
use App\Data\Person;
use App\Data\Bar;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceContainerTest extends TestCase
{
    public function testDependecy() {
        // $foo = new Foo();
        $foo = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertEquals('Foo', $foo->foo());
        self::assertEquals('Foo', $foo2->foo());
        self::assertSame($foo, $foo2);
    }

    public function testBind()
    {
        // $person = $this->app->make(Person::class);
        // self::assertNotNull($person);

        $this->app->bind(Person::class, function ($app){
            return new Person('Randi', 'Febriadi');
        });

        $person = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals('Randi', $person->firstName);
        self::assertEquals('Randi', $person2->firstName);
        self::assertNotSame($person, $person2);
    }
    
    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app){
            return new Person('Randi', 'Febriadi');
        });

        $person = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals('Randi', $person->firstName);
        self::assertEquals('Randi', $person2->firstName);
        self::assertSame($person, $person2);
    }

    public function testIntance()
    {
        $person = new Person('Randi', 'Febriadi');
        $this->app->instance(Person::class, $person);

        $person = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);
        $person3 = $this->app->make(Person::class);
        $person4 = $this->app->make(Person::class);

        self::assertEquals('Randi', $person->firstName);
        self::assertEquals('Randi', $person2->firstName);
        self::assertSame($person, $person2);
    }

    public function testDependecyInjection() {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);
        
        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        // $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $this->app->singleton(HelloService::class, function ($app) {
            return new HelloServiceIndonesia();
        });
        
        $helloService = $this->app->make(HelloService::class);

        self::assertEquals("Halo Randi", $helloService->hello('Randi'));
    }
}
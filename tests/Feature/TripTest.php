<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DB;

class TripTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_list_no_data(): void
    {
        $this->json('GET', 'api/trips/get', ['Accept' => 'application/json'])
        ->assertStatus(422)
        ->assertJson([
            "message" => "The from field is required. (and 1 more error)"
        ]);
    }


    public function test_list_false_data(): void
    {
        $this->json('GET', 'api/trips/get?from=test132&to=1341', ['Accept' => 'application/json'])
        ->assertStatus(422)
        ->assertJson([
            "message" => "The selected from is invalid. (and 1 more error)"
        ]);
    }


    public function test_list_success(): void
    {
        $this->json('GET', 'api/trips/get?from=cairo&to=asyut', ['Accept' => 'application/json'])
        ->assertStatus(200);
    }


    public function test_create_success(): void
    {
        DB::beginTransaction();
        $userData = [
            "from"=>"cairo",
            "to" => "asyut",
            "customer"=>"test",
            "bus"=>"1",
            "seat"=>"a3"
        ];
        $this->json('POST', 'api/book',$userData, ['Accept' => 'application/json'])
        ->assertStatus(200);


        DB::rollback();
    }

    public function test_create_no_bus(): void
    {
        DB::beginTransaction();
        $userData = [
            "from"=>"cairo",
            "to" => "asyut",
            "customer"=>"test",
            "bus"=>"100",
            "seat"=>"a3"
        ];
        $this->json('POST', 'api/book',$userData, ['Accept' => 'application/json'])
        ->assertStatus(422)
        ->assertJson([
            "message" => "bus not avaiable for that route please check list again"
        ]);


        DB::rollback();
    }


    public function test_create_no_route(): void
    {
        DB::beginTransaction();
        $userData = [
            "from"=>"cairo",
            "to" => "giza",
            "customer"=>"test",
            "bus"=>"100",
            "seat"=>"a3"
        ];
        $this->json('POST', 'api/book',$userData, ['Accept' => 'application/json'])
        ->assertStatus(422)
        ->assertJson([
            "message" => "this route is not available, please check listing again"
        ]);


        DB::rollback();
    }


}

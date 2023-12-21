<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function asUser(): TestCase
    {
        return test()->actingAs(User::factory()->create());
    }


}

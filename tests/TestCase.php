<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * A trait RefreshDatabase usa o comando do artisan migrate:refresh que delet as tabelas mas nao deleta as views,
     * para deletar as views a trait precisa que este atributo esteja com valor true
     *
     * https://github.com/laravel/framework/issues/21193
     */
    public $dropViews = true;
}

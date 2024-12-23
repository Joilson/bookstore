<?php

namespace App\DTOs\Inputs;

use Illuminate\Http\Request;

interface InputDTOInterface
{
    public static function fromRequest(Request $request): self;
}

<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Author',
    properties: [
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'updated_at', type: 'datetime'),
        new OA\Property(property: 'created_at', type: 'datetime'),
        new OA\Property(property: 'id', type: 'integer'),
    ],
    type: 'object'
)]
class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';

    protected $fillable = [
        'name',
    ];
}

<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Book',
    properties: [
    new OA\Property(property: 'id', type: 'integer'),
    new OA\Property(property: 'title', type: 'string'),
    new OA\Property(property: 'publisher', type: 'string'),
    new OA\Property(property: 'edition', type: 'integer'),
    new OA\Property(property: 'publicationYear', type: 'integer'),
    new OA\Property(property: 'price', type: 'float'),
    new OA\Property(property: 'updatedAt', type: 'datetime'),
    new OA\Property(property: 'createdAt', type: 'datetime'),
    new OA\Property(property: 'authors', type: 'array', items: new OA\Items(ref: '#/components/schemas/Author')),
    new OA\Property(property: 'subjects', type: 'array', items: new OA\Items(ref: '#/components/schemas/Subject')),
    ],
    type: 'object'
)]
class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'publisher',
        'edition',
        'publication_year',
        'price'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'double',
        ];
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(
            Author::class,
            'book_author',
            'book_id',
            'author_id'
        );
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(
            Subject::class,
            'book_subject',
            'book_id',
            'subject_id'
        );
    }
}

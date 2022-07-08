<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use JetBrains\PhpStorm\ArrayShape;

interface CrudListInterface
{
    public function getTableName(): string;

    public function getWith(): ?string;
    public function getExtraQuery($query): ?Builder;

    #[ArrayShape(['enabled' => "bool", 'placeholder' => "string", 'searchFields' => "string[]"])]
    public function getSearchOptions(): array;

    public function buildTable();

    public function hasPagination(): bool;

    #[ArrayShape(['enabled' => "bool", 'perPage' => "int"])]
    public function getPerPageOptions(): array;
}

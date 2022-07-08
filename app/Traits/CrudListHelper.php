<?php


namespace App\Traits;

use App\Extensions\ApiPagination;
use App\Facades\Client;
use App\Models\BaseModel;

trait CrudListHelper
{
    public $search = '';
    public $sortAsc = 'desc';
    public $perPage;
    public $searchFields = [];

    public string $name = 'Dynamic Table';

    public bool $searchEnabled = true;
    public bool $paginateEnable = true;

    public string $template = 'livewire.dynamic-table';

    public function sortBy($field)
    {
        if ($this->sortAsc === 'asc') {
            $this->sortAsc = 'desc';
        } else {
            $this->sortAsc = 'asc';
        }
        return $this->sortField = $field;
    }

    public function canSearch(): bool
    {
        return @ $this->getSearchOptions()['enabled'];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view($this->template)
            ->with([
                'data'  => $this->filter(),
                'table' => $this->buildTable()
            ]);
    }

    public function filter()
    {
//        if ($this->hasProperty('model')) {
//            $model = $this->model;
//        }
        $query = $this->model::applyWhere($this->buildWheres())
            ->orderBy($this->sortField ?: 'id', $this->sortAsc);


        if ($extraQuery = $this->getExtraQuery($query)) {
            $query = $extraQuery;
        }

        if ($with = $this->getWith()) {
            $query = $query->with($with);
        }

        if (! $this->hasPagination()) {
            return $query->get();
        }

        return $query->paginate($this->getPerPageValue('perPage'));
    }

    public function buildWheres(): array
    {
        $wheres = [];
        if (count((array)$this->getSearchValue('searchFields'))) {
            foreach ($this->getSearchValue('searchFields') as $field) {
                $wheres[$field] = [
                    'operator' => 'like',
                    'value'    => $this->search
                ];
            }
        }
        return $wheres;
    }

    public function getSearchValue($value): mixed
    {
        return @ $this->getSearchOptions()[$value];
    }

    public function getPerPageValue($value): mixed
    {
        if ($value === 'perPage') {
            if (is_null($this->perPage)) {
                $perPage = @ $this->getPerPageOptions()[$value];
                $this->perPage = $perPage;
                return $perPage;
            }
            return $this->perPage;
        }
        return @ $this->getPerPageOptions()[$value];
    }

    public function paginate($companies): ApiPagination
    {
        return (new ApiPagination(
            $companies['data'],
            $companies['total'],
            $companies['last_page'],
            $companies['per_page'],
            $companies['current_page']
        ));
    }

    public function is_multi_array($arr): bool
    {
        return (! array_is_list($arr));
    }
}

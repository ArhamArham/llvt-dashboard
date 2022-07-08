@if ($sortField !== $field)
    <i class=" text-muted fas fa-sort"></i>
@elseif ($sortAsc === 'asc')
    <i style="color:#6c757d" class="fas fa-sort-up"></i>
@else
    <i style="color:#6c757d" class="fas fa-sort-down"></i>
@endif

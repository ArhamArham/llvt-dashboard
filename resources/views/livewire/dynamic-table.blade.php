<div>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $this->getTableName() }}
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2"
             style="justify-content: space-between">
            @if(@ $createUrl)
                <div class="col-12 text-right">
                    <a href="{{ route($createUrl) }}" class="btn btn-primary shadow-md mr-2">Create</a>
                </div>
            @endif
            {{--            <div class="dropdown">--}}
            {{--                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">--}}
            {{--                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>--}}
            {{--                </button>--}}
            {{--                <div class="dropdown-menu w-40">--}}
            {{--                    <ul class="dropdown-content">--}}
            {{--                        <li>--}}
            {{--                            <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li>--}}
            {{--                            <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>--}}
            {{--                                Export to Excel </a>--}}
            {{--                        </li>--}}
            {{--                        <li>--}}
            {{--                            <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>--}}
            {{--                                Export to PDF </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            @if($this->canSearch())
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <input type="text" class="form-control w-56 box pr-10" wire:model.debounce.1000ms="search"
                               placeholder="{{ $this->getSearchValue('placeholder') }}">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>
                </div>
            @endif

        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                <tr>
                    @foreach($table as $index => $header)
                        <th style="cursor: pointer"
                            class="text-center whitespace-nowrap @if($sortField !== @ $header['key']) {{ @ $header['sort'] ? "sorting" : "" }} @else {{ $sortAsc === 'asc' ? "sorting_asc" : "sorting_desc" }}  @endif"
                            rowspan="1" colspan="1"
                            @if(@ $header['sort']) wire:click="sortBy('{{@ $header['key']}}')" @endif>
                            {{ $header['name'] }}
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>

                @foreach($data as $key => $value)
                    <tr class="intro-x">
                        @foreach($table as $header)
                            <td class="w-40 text-center {{ @ $header['class'] }}">
                                @if(isset($header['key']))
                                    @if(@ $header['dot'])
                                        {{ Arr::get($value,$header['key']) }}
                                    @else
                                        {{ $value->{$header['key']} ?? @ $header['default'] }}
                                    @endif
                                @elseif(isset($header['default']))
                                    {{ $header['default'] }}
                                @elseif(isset($header['cb']))
                                    @if(isset($header['html']))
                                        {!! $header['cb']($value) !!}
                                    @else
                                        {{ $header['cb']($value) }}
                                    @endif
                                @elseif(isset($header['image']))
                                    <div class="w-10 h-10 image-fit zoom-in mx-auto">
                                        <img class="rounded-full" src="{{ $value->{$header['image']} }}">
                                    </div>
                                @elseif(isset($header['imagesCb']))
                                    @php $images = $header['imagesCb']($value) @endphp
                                    @if(gettype($images) =='string')
                                        <div class="w-10 h-10 image-fit zoom-in mx-auto">
                                            <img class="rounded-full" src="{{ $images }}">
                                        </div>
                                    @else
                                        <div class="flex">
                                            @foreach($images as $key => $img)
                                                <div class="w-10 h-10 image-fit zoom-in @if($key > 0) -ml-5 @endif">
                                                    <img class="tooltip rounded-full"
                                                         src="{{ $img }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @elseif(isset($header['checkActive']))
                                    @if($value->{$header['checkActive']})
                                        <div class="flex items-center justify-center text-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round" icon-name="check-square"
                                                 data-lucide="check-square"
                                                 class="lucide lucide-check-square w-4 h-4 mr-2">
                                                <polyline points="9 11 12 14 22 4"></polyline>
                                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                            </svg>
                                            Active
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center text-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round" icon-name="check-square"
                                                 data-lucide="check-square"
                                                 class="lucide lucide-check-square w-4 h-4 mr-2">
                                                <polyline points="9 11 12 14 22 4"></polyline>
                                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                            </svg>
                                            Inactive
                                        </div>
                                    @endif
                                @elseif(isset($header['anchor']))
                                    @if($this->is_multi_array($header['anchor']))
                                        <a href="{{ isset($header['anchor']['route']) ? $header['anchor']['route']($value) :'' }}"
                                           class="">
                                            @if($header['anchor']['name'] instanceof Closure)
                                                {{ $header['anchor']['name']($value) }}
                                            @else
                                                {{ $header['anchor']['name'] }}
                                            @endif
                                        </a>
                                    @else
                                        @foreach($header['anchor'] as $anchor)
                                            <a href="{{ isset($anchor['route']) ? $anchor['route']($value) :'' }}"
                                               @if(isset($anchor['onclick'])) onclick="{{ $anchor['onclick'] }}(event)"
                                               @endif
                                               class="{{ @ $anchor['class'] }}">
                                                @if($anchor['name'] instanceof Closure)
                                                    {{ $anchor['name']($value) }}
                                                @else
                                                    {{ $anchor['name'] }}
                                                @endif
                                            </a>
                                            @if(!$loop->last) | @endif
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                @if(count($data) === 0)
                    <tr class="intro-x">
                        <td valign="top" colspan="{{ count($table) }}" class="text-center">No data available in table</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
            @if($this->hasPagination())
                {{ $data->links('vendor.livewire.tailwind') }}
            @endif

            @if($this->getPerPageValue('enabled'))
                <select class="w-20 form-select box mt-3 sm:mt-0">
                    <option>10</option>
                    <option>25</option>
                    <option>35</option>
                    <option>50</option>
                </select>
            @endif
        </div>
        <!-- END: Pagination -->
    </div>

</div>

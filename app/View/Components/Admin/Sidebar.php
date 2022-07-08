<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $menu = [];

    public function __construct()
    {
        $this->menu = collect([
            [
                'name'      => 'Dashboard',
                'icon'      => 'home',
                'link'      => route('admin.dashboard'),
                'condition' => 'dashboard',
                'child'     => [],
            ],
            [
                'name'  => 'Setting',
                'icon'  => 'activity',
                'child' => [
                    [
                        'name'      => 'Website',
                        'icon'      => 'activity',
                        'link'      => route('admin.setting.website.index'),
                        'condition' => 'setting.website',
                        'child'     => [],
                    ],
                ],
            ]
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     * @return View|string
     */
    public function render()
    {
        $this->convertMenuArrayIntoCollection();

        return view('components.admin.sidebar');
    }

    protected function convertMenuArrayIntoCollection(): void
    {
        $this->menu = $this->menu->map(function ($item) {
            return collect($item)->map(function ($value) {
                return (is_array($value)) ? collect($value)->map(function ($value) {
                    return collect($value)->map(function ($value) {
                        return (is_array($value)) ? collect($value)->map(function ($value) {
                            return collect($value);
                        }) : $value;
                    });
                }) : $value;
            });
        });
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LocaleBadge extends Component
{
    private $colors = [
        'en' => 'bg-blue-400',
        'sk' => 'bg-yellow-500',
        'de' => 'bg-red-400',
        'se' => 'bg-green-500',
    ];
    public $color;
    public $lang;

    public function __construct($lang) {
        $this->lang = $lang;
        $this->color = $this->getColor();
    }

    private function getColor() {
        $color = $this->colors[$this->lang];
        if (!$color) {
            $color = 'bg-gray-400';
        }
        return $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.locale-badge');
    }
}

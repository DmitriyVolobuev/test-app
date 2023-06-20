<?php

namespace App\Http\Livewire;

use App\Models\Image;
use Livewire\Component;
use Livewire\WithPagination;

class ImagePagination extends Component
{
    use WithPagination;

    public function render()
    {
        $images = Image::paginate(9);

        return view('index', [
            'images' => $images
        ]);
    }
}


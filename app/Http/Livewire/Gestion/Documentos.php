<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Documento;

class Documentos extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'id';
    public $direction = 'desc';

    public function render()
    {
        $documentos = Documento::where('numero', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.gestion.documentos',compact('documentos'));
    }
}

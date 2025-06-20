<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class AgreementList extends Component
{
    public function render()
    {
        return view('livewire.dashboard.agreement-list');
    }
}

<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(name: 'components.layouts.dashboard')]
class AgreementDetails extends Component
{
    public function render()
    {
        return view('livewire.dashboard.agreement-details');
    }
}

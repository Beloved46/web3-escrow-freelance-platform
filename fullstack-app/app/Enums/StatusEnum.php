<?php

namespace App\Enums;

enum StatusEnum :string
{
    case CREATED = 'Created';   // Agreement created but not yet funded
    case FUNDED = 'Funded';    // Client has funded the escrow
    case INPROGRESS = 'InProgress';// Work is in progress
    case DISPUTED = 'Disputed';  // Agreement is under dispute
    case COMPLETED = 'Completed'; // Work completed and funds released
    case CANCELLED = 'Cancelled';  // Agreement cancelled and funds returned to client
}

<?php

namespace App\Enums;

enum MilestonesEnum :string
{
    case PENDING = 'Pending';   // Milestone created but not yet approved
    case APPROVED = 'Approved';  // Client approved the milestone work
    case REJECTED = 'Rejected';   // Client rejected the milestone work
}

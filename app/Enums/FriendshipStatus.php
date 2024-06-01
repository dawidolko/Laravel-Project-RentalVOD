<?php

namespace App\Enums;

enum FriendshipStatus: string
{
    case Pending = 'oczekiwanie';
    case Accepted = 'zaakceptowane';
    case Declined = 'odrzucone';
}

<?php

namespace App\Entity\Pipedrive\Status;

enum Status: String
{
    case open = "open";
    case won = "won";
    case lost = "lost";
}

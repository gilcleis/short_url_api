<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function lastVisit(ShortUrl $shortUrl)
    {
        return [
            'last_visit' => $shortUrl->last_visit?->toIso8601String(),
        ];
    }
}

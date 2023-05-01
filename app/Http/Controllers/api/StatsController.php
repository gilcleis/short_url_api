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

    public function visits(ShortUrl $shortUrl)
    {

        $visits = $shortUrl->visits()
            ->selectRaw("
                to_char(created_at, 'YYYY-mm-dd') as date,
                COUNT(*) as count
           ")
            ->groupByRaw('1')
            ->get();

        ray($visits->toArray());
        // dd($visits->toArray());
        return [
            'total'  => $shortUrl->visits()->count(),
            'visits' => $visits->toArray(),
        ];
    }
}

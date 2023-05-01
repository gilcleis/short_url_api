<?php

namespace App\Http\Controllers\api;

use App\Facades\Actions\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShortUrlController extends Controller
{

    public function store()
    {
        $url  = request('url');
        $code = CodeGenerator::run();

        $shortUrl = ShortUrl::query()
            ->create([
                'url'       => $url,
                'short_url' => config('app.url') . '/' . $code,
                'code'      => $code,
            ]);

        return response()->json([
            'short_url' => $shortUrl->short_url,
        ], Response::HTTP_CREATED);
    }
}

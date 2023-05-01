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
        request()->validate(['url' => 'required|url']);

        $code = CodeGenerator::run();

        $shortUrl = ShortUrl::query()
            ->firstOrCreate([
                'url' => request('url'),
            ], [
                'url'       => request('url'),
                'short_url' => config('app.url') . '/' . $code,
                'code'      => $code,
            ]);

        return response()->json([
            'short_url' => $shortUrl->short_url,
        ], Response::HTTP_CREATED);
    }


    public function destroy(ShortUrl $shortUrl)
    {
        $shortUrl->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

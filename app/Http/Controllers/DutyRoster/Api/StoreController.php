<?php

namespace App\Http\Controllers\DutyRoster\Api;

use App\Http\Controllers\Controller;
use App\Jobs\DutyRoster\StoreDutyRoster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class StoreController extends Controller
{
    private const FIELD_FILE = 'file';

    public function __invoke(Request $request): JsonResponse
    {
        $file = $request->file(self::FIELD_FILE);
        StoreDutyRoster::dispatchSync($file->getMimeType(), $file->getContent());

        return response()->json(null, Response::HTTP_CREATED);
    }
}

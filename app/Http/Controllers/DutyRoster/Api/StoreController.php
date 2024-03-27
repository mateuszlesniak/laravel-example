<?php

namespace App\Http\Controllers\DutyRoster\Api;

use App\Http\Controllers\Controller;
use App\Jobs\DutyRoster\StoreDutyRoster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

final class StoreController extends Controller
{
    private const FIELD_FILE = 'file';

    public function __invoke(Request $request): JsonResponse
    {
        $file = $request->file(self::FIELD_FILE);

        StoreDutyRoster::dispatchSync($file->getMimeType(), $file->getContent());

//        $domDocument = new Crawler($file);
//
//        $dateRange = $domDocument->filter('select#ctl00_Main_periodSelect')->first();
//        $dateRange = $dateRange->filter('option[selected]')->first()->attr('value');
//
//        $table = $domDocument->filter('table#ctl00_Main_activityGrid')->first();
//
//        $table->filter('tr')->each(function (Crawler $row, int $index) {
//            if ($index === 0) {
//                return;
//            }
//
//            $values = $row->filter('td');
//
//        });
        return response()->json('Hello!', Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\DutyRoster\Api;

use App\DutyRoster\Repository\RosterRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\RosterResource;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class GetEventController extends Controller
{

    public function __construct(
        private readonly RosterRepositoryInterface $rosterRepository,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $startDate = $request->get('start_date', null);
        $endDate = $request->get('end_date', null);

        try {
            $startDate = $this->createDateFromString($startDate);
            $endDate = $this->createDateFromString($endDate);
        } catch (Exception $exception) {
            return response()->json(null, Response::HTTP_BAD_REQUEST);
        }

        return response()->json(RosterResource::collection(
            $this->rosterRepository->findRostersBetweenDates($startDate, $endDate)
        ), Response::HTTP_OK);
    }

    private function createDateFromString(string $date): DateTime
    {
        if (empty($date)) {
            throw new Exception();
        }

        $date = DateTime::createFromFormat('Y-m-d', $date);

        if (!$date) {
            throw new Exception();
        }

        return $date;
    }
}

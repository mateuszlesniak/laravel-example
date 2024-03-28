<?php

namespace App\Http\Controllers\DutyRoster\Api;

use App\DutyRoster\Repository\RosterRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\RosterResource;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetScheduleController extends Controller
{
    public function __construct(
        private readonly RosterRepositoryInterface $rosterRepository,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $startDate = $this->createDateFromString($request->get('start_date', null));

        return response()->json(RosterResource::collection(
            $this->rosterRepository->findRostersBetweenDates($startDate, (clone $startDate)->modify('+7 days'))
        ), Response::HTTP_OK);
    }

    private function createDateFromString(?string $date): DateTime
    {
        if (empty($date)) {
            return new DateTime('2022-01-14');
        }

        $date = DateTime::createFromFormat('Y-m-d', $date);

        if (!$date) {
            return new DateTime('2022-01-14');
        }

        return $date;
    }
}

<?php

namespace App\Http\Controllers\DutyRoster\Api;

use App\DutyRoster\Dtr\ActivityEnum;
use App\DutyRoster\Repository\RosterRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\RosterResource;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;

class GetScheduleController extends Controller
{
    public function __construct(
        private readonly RosterRepositoryInterface $rosterRepository,
    )
    {
    }

    public function __invoke(Request $request, string $activityCode): JsonResponse
    {
        $startDate = $this->createDateFromString($request->get('start_date', null));

        try {
            $activity = $this->createActivityFromString($activityCode);
        } catch (InvalidArgumentException) {
            return response()->json(null, Response::HTTP_BAD_REQUEST);
        }

        return response()->json(RosterResource::collection(
            $this->rosterRepository->findByCriteria(
                $startDate,
                (clone $startDate)->modify('+7 days'),
                $activity,
            )
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

    private function createActivityFromString(?string $activityCode): ?ActivityEnum
    {
        if (empty($activityCode)) {
            return null;
        }

        $activity = ActivityEnum::tryFrom($activityCode);

        if(!$activity) {
            throw new InvalidArgumentException();
        }

        return $activity;
    }
}

<?php

namespace App\Http\Controllers\DutyRoster\Api;

use App\DutyRoster\Repository\RosterRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\RosterResource;
use App\Location\LocationRepositoryInterface;
use App\Models\Location;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;

final class GetEventController extends Controller
{
    public function __construct(
        private readonly RosterRepositoryInterface $rosterRepository,
        private readonly LocationRepositoryInterface $locationRepository,
    )
    {
    }

    public function __invoke(Request $request, ?string $locationCode = null): JsonResponse
    {
        $startDate = $request->get('start_date', null);
        $endDate = $request->get('end_date', null);

        try {
            $startDate = $this->createDateFromString($startDate);
            $endDate = $this->createDateFromString($endDate);
            $location = $this->findLocationCode($locationCode);
        } catch (InvalidArgumentException $exception) {
            return response()->json(null, Response::HTTP_BAD_REQUEST);
        }


        return response()->json(RosterResource::collection(
            $this->rosterRepository->findByCriteria($startDate, $endDate, null, $location)
        ), Response::HTTP_OK);
    }

    private function createDateFromString(?string $date = null): ?DateTime
    {
        if (empty($date)) {
            return null;
        }

        $date = DateTime::createFromFormat('Y-m-d', $date);

        if (!$date) {
            throw new InvalidArgumentException();
        }

        return $date;
    }

    private function findLocationCode(?string $locationCode = null): ?Location
    {
        if (empty($locationCode)) {
            return null;
        }

        $location = $this->locationRepository->find($locationCode);

        if (!$location) {
            throw new InvalidArgumentException();
        }

        return $location;
    }
}

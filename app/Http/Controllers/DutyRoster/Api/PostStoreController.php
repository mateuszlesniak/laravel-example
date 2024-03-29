<?php

namespace App\Http\Controllers\DutyRoster\Api;

use App\DutyRoster\Shared\Exception\EmptyDataException;
use App\DutyRoster\Shared\Exception\MimeTypeNotSupportedException;
use App\Http\Controllers\Controller;
use App\Jobs\DutyRoster\StoreDutyRoster;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;

final class PostStoreController extends Controller
{
    private const FIELD_FILE = 'file';

    public function __invoke(Request $request): JsonResponse
    {
        $file = $request->file(self::FIELD_FILE);

        $message = null;
        if (!$file?->isValid()) {
            return response()->json($message, Response::HTTP_BAD_REQUEST);
        }

        try {
            StoreDutyRoster::dispatchSync($file->getMimeType(), $file->getContent());

            $responseCode = Response::HTTP_CREATED;
        } catch (EmptyDataException) {
            $responseCode = Response::HTTP_NO_CONTENT;
        } catch (MimeTypeNotSupportedException|InvalidArgumentException $exception) {
            if ($exception instanceof MimeTypeNotSupportedException) {
                $message = $exception->getMessage();
            }

            $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } catch (Exception $exception) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json($message, $responseCode);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckInRequest;
use App\Http\Resources\VisitDetailed as VisitDetailedResource;
use App\Models\Visit;
use Exception;

class CheckInController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/visits/check-in",
     * summary="Check a visitor into a building",
     * description="Check a visitor into a building",
     * operationId="checkIn",
     * tags={"checkIn"},
     * @OA\RequestBody(
     *    required=true,
     *    description="visit request",
     *       @OA\JsonContent(
     *       required={"code"},
     *          @OA\Property(property="code", type="string"),
     *         
     *    ),
     * ),
     * 
     * * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="")
     *        )
     *     )
     * )
     * 
     */
    /**
     * Check a visitor into a building.
     *
     * @param \App\Http\Requests\CheckInRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function checkIn(CheckInRequest $request)
    {
        $visit = Visit::identify($request['code']);

        if ($visit->checked_out_at)
            throw new Exception("The visit already finished.");

        if (!$visit->checked_in_at)
        {   
            if ($visit->approval == "CANCELLED")
                throw new Exception("The visit is cancelled.");

            if ($visit->requires_approval && $visit->approval != "APPROVED")
                throw new Exception("The visit still awaits approval.");
            
            // TODO: enforce time constraints on check-in relative to scheduled_at
            // See https://carbon.nesbot.com/docs for help

            $visit->checked_in_at = now();
        }
        else
        {   
            // Prevent checking out by mistake by scanning code twice.
            if (now()->diffInMinutes($visit->checked_in_at) < 1)
                throw new Exception("The visit just started.");

            $visit->checked_out_at = now();
        }

        $visit->save();

        return new VisitDetailedResource($visit);
    }
}

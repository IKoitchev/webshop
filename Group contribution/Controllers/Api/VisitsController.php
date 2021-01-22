<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\VisitRequest;
use App\Models\Employee;
use App\Models\Visit;
use App\Models\Building;
use App\Http\Resources\Visit as VisitResource;
use App\Http\Resources\VisitDetailed as VisitDetailedResource;
use App\Mail\VisitCreated;
use Exception;
use Mail;

class VisitsController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/visits",
     * summary="Visits related to the logged in employee",
     * description="Visits related to the logged in employee",
     * operationId="visitsForEmployee",
     * tags={"visits"},
     * 
     * * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="")
     *        )
     *     ),
     * security={{"bearer":{}}},
     * )
     * 
     */
    /**
     * Display a listing of visits related to the currently logged in employee.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VisitResource::collection(auth()->user()->visits);
    }



    

    /**
     * @OA\Get(
     * path="/api/visits/{visit}",
     * summary="Detailed visit information",
     * description="Detailed visit information",
     * operationId="visitInformation",
     * tags={"visits"},
     *  @OA\Parameter(
     *    name="visit",
     *    description="visit id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example=" ")
     *        )
     *     ),
     *  security={{"bearer":{}}},
     * )
     * 
     */
    /**
     * Display a detailed visit information.
     *
     * @param  \App\Http\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function show(Visit $visit)
    {
        if (!Gate::allows('show', $visit))
            throw new AuthorizationException();

        return new VisitDetailedResource($visit);
    }
    /**
     * @OA\Post(
     * path="/api/visits/{visit}/approve",
     * summary="Approve a visit",
     * description="Approve a visit",
     * operationId="visitApproval",
     * tags={"visits"},
     *  @OA\Parameter(
     *    name="visit",
     *    description="visit id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example=" ")
     *        )
     *     ),
     *  security={{"bearer":{}}},
     * )
     * 
     */
    /**
     * Approve a visit.
     *
     * @param  \App\Http\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function approve(Visit $visit)
    {
        if (!Gate::allows('approve', $visit))
            throw new AuthorizationException();

        if ($visit->checked_out_at)
            throw new Exception("The visit already finished.");

        if ($visit->checked_in_at)
            throw new Exception("The visit already started.");

        switch ($visit->approval)
        {
            case "CANCELLED":
                throw new Exception("The visit was already cancelled.");

            case "APPROVED":
                throw new Exception("The visit was already approved.");

            default:
                $visit->approval = "APPROVED";
                $visit->save();
                break;
        }

        // TODO: notify the visitor via email

        return new VisitDetailedResource($visit);
    }
    /**
     * @OA\Post(
     * path="/api/visits/{visit}/cancel",
     * summary="Cancel a visit",
     * description="Cancel a visit",
     * operationId="visitCancelation",
     * tags={"visits"},
     *  @OA\Parameter(
     *    name="visit",
     *    description="visit id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example=" ")
     *        )
     *     ),
     *  security={{"bearer":{}}},
     * )
     * 
     */
    /**
     * Cancel a visit.
     *
     * @param  \App\Http\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function cancel(Visit $visit)
    {
        if (!Gate::allows('cancel', $visit))
            throw new AuthorizationException();

        if ($visit->checked_out_at)
            throw new Exception("The visit already finished.");

        if ($visit->checked_in_at)
            throw new Exception("The visit already started.");

        switch ($visit->approval)
        {
            case "CANCELLED":
                throw new Exception("The visit was already cancelled.");

            default:
                // Allow cancelling both pending and approved visits
                $visit->approval = "CANCELLED";
                $visit->save();
                break;
        }

        // TODO: notify the visitor via email

        return new VisitDetailedResource($visit);
    }
    /**
     * @OA\Get(
     * path="/api/buildings/{building}/visits",
     * summary="Display a listing of visits within a building",
     * description="Display a listing of visits within a building",
     * operationId="visitForBuilding",
     * tags={"visits"},
     *  @OA\Parameter(
     *    name="building",
     *    description="building id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example=" ")
     *        )
     *     ),
     *  security={{"bearer":{}}},
     * )
     * 
     */
    /**
     * Display a listing of visits within a building.
     *
     * @param  \App\Http\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function indexBuilding(Building $building)
    {
        if (!Gate::allows('indexVisits', $building))
            throw new AuthorizationException();

        return VisitResource::collection(
            $building->visits->filter(
                function ($visit) {
                    return $visit->employee->company_id == auth()->user()->company_id;
                }
            ));
    }
    /**
     * @OA\Post(
     * path="/api/visits",
     * summary="Store a newly created resource in storage",
     * description="Store a newly created resource in storage",
     * operationId="storeNewVisit",
     * tags={"visits"},
     * @OA\RequestBody(
     *    required=true,
     *    description="visit request",
     *       @OA\JsonContent(
     *       required={"first_name", "last_name", "email", "scheduled_at", "building_id", "employee_id" },
     *          @OA\Property(property="first_name", type="string"),
     *          @OA\Property(property="last_name", type="string"),
     *          @OA\Property(property="email", type="string"),
     *          @OA\Property(property="code_type", type="string"),
     *          @OA\Property(property="scheduled_at", type="date"),
     *          @OA\Property(property="building_id", type="integer"),   
     *          @OA\Property(property="employee_id", type="integer"),    
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\VisitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitRequest $request)
    {
        // Start prepering the visit
        $visit = new Visit($request->only([
            'employee_id',
            'building_id',
            'first_name',
            'last_name',
            'email',
            'code_type',
            'scheduled_at'
        ]));

        // TODO: add support for alphanumeric codes
        $visit->code_type = $request['code_type'] ?? 'QR';
        $visit->code = Visit::generateQR();

        // Attach currently registereg custom fields
        if ($request->has('custom'))
            $visit->custom = collect($request['custom'])
                ->only($visit->fields()->get('title')->map(
                    function ($field) {
                        return $field['title'];
                    })
                );

        $visit->save();

        if (env('MAIL_ENABLED', false)) {
            Mail::to($visit->email)->send(new VisitCreated($visit));
        }

        return new VisitDetailedResource($visit);
    }
}

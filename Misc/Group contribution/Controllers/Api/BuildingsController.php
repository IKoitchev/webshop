<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Company;
use App\Http\Resources\Building as BuildingResource;
use App\Http\Resources\Company as CompanyResource;
use App\Http\Requests\BuildingApprovalRequest;
use Exception;

class BuildingsController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/buildings/",
     * summary="Get a list of all buildings",
     * description="Get a list of all buildings",
     * operationId="getAllBuildings",
     * tags={"buildings"},
     * @OA\RequestBody(
     *    required=false,
     *    description="buildings",
     *    
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     )
     * )
     */
    /**
     * Display a listing of buildings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BuildingResource::collection(Building::all());
    }
    /**
     * @OA\Get(
     * path="/api/buildings/{building}",
     * summary="Get building by id",
     * description="Get building by id",
     * operationId="getBuildingById",
     * tags={"buildings"},
     * @OA\Parameter(
     *    name="building",
     *    description="building id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     )
     * )
     */
    /**
     * Display the specified building.
     *
     * @param  \App\Models\Building $building
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        return $building;
    }
    /**
     * @OA\Get(
     * path="/api/buildings/{building}/companies",
     * summary="Get companies in a building",
     * description="Get companies in a building",
     * operationId="getCompaniesInBuilding",
     * tags={"buildings"},
     * @OA\Parameter(
     *    name="building",
     *    description="building id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     )
     * )
     */
    /**
     * Display a listing of companies within a building.
     *
     * @param  \App\Models\Building $building
     * @return \Illuminate\Http\Response
     */
    public function companies(Building $building)
    {
        return CompanyResource::collection($building->companies);
    }
    /**
     * @OA\Get(
     * path="/api/companies/{company}/buildings/{building}/approval",
     * summary="Get approval",
     * description="Get approval",
     * operationId="GetApproval",
     * tags={"buildings"},
     * @OA\Parameter(
     *    name="building",
     *    description="building id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     * @OA\Parameter(
     *    name="company",
     *    description="company id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     )
     * )
     */
    /**
     * Display a listing of companies within a building.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function getApproval(Company $company, Building $building)
    {
        $pivot = Building::CompanyPivot($building, $company);

        if (!$pivot->exists())
            throw new Exception('The specified building does not belong to the company.');

        return [
            'requires_approval' => (boolean) $pivot->value('requires_approval')
        ];
    }
    /**
     * @OA\Put(
     * path="/api/buildings/{building}/approval",
     * summary="Get an approval",
     * description="Get an approval",
     * operationId="getApproval",
     * tags={"buildings"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Building approval request",
     *    @OA\JsonContent(
     *       required={"required"},
     *       @OA\Property(property="required", type="boolean", format="boolean", example="true"),    
     *    ),
     * ),
     *  @OA\Parameter(
     *    name="building",
     *    description="building id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
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
     * Display a listing of companies within a building.
     *
     * @param \App\Http\Requests\BuildingApprovalRequest  $request
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function toggleApproval(BuildingApprovalRequest $request, Building $building)
    {
        $pivot = Building::CompanyPivot($building, auth()->user()->company);

        if (!$pivot->exists())
            throw new Exception('The specified building does not belong to the company.');

        $resource = $pivot->update($request->only(['requires_approval']));

        return [
            'requires_approval' => (boolean) $pivot->value('requires_approval')
        ];
    }
}

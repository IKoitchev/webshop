<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Building;
use App\Models\FormField;
use App\Http\Resources\FormField as FormFieldResource;
use App\Http\Requests\FieldsRequest;

class FormsController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/companies/{company}/buildings/{building}/fields",
     * summary="Get company fields",
     * description="Get company fields",
     * operationId="getFields",
     * tags={"forms"},
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
     * Display a detailed visit information.
     *
     * @param  \App\Http\Models\Company  $company
     * @param  \App\Http\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function list(Company $company, Building $building)
    {
        return FormFieldResource::collection(
            FormField::FindForm($company, $building)->get()
        );
    }
    /**
     * @OA\Put(
     * path="/api/buildings/{building}/update",
     * summary="Update fields",
     * description="Update fields",
     * operationId="updateFields",
     * tags={"forms"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Fields request",
     *    @OA\JsonContent(
     *       required={"fields", "fields.*.title", "fields.*.kind"},
     *       @OA\Property(property="fields", type="string"),
     *       @OA\Property(property="fields.*.title", type="string"),  
     *       @OA\Property(property="fields.*.kind", type="string"),
     *       @OA\Property(property="fields.*.required", type="string"), 
     *       @OA\Property(property="fields.*.overview", type="string"),     
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
     * Display a detailed visit information.
     * 
     * @param  App\Http\Requests\FieldsRequest  $request
     * @param  \App\Http\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(FieldsRequest $request, Building $building)
    {
        // Remove existing fields
        FormField::FindForm(
            auth()->user()->company,
            $building
        )->delete();

        $i = 0;

        // Save new fields and mark their order
        foreach($request['fields'] ?? [] as $field)
            FormField::Create([
                    'company_id' => auth()->user()->company->id,
                    'building_id' => $building->id,
                    'order' => $i++,
                ] + collect($field)->only(
                    'title',
                    'kind',
                    'required',
                    'overview'
                )->toArray()
            );
        
        return $this->list(auth()->user()->company, $building);
    }
}

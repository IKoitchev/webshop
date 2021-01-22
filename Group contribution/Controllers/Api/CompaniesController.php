<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Building;
use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\Building as BuildingResource;
use App\Http\Resources\Employee as EmployeeResource;

class CompaniesController extends Controller
{
     /**
     * @OA\Get(
     * path="/api/companies/",
     * summary="Get a list of all companies",
     * description="Get a list of all companies",
     * operationId="getAllCompanies",
     * tags={"companies"},
     * @OA\RequestBody(
     *    required=false,
     *    description="companies",
     *    
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="")
     *        )
     *     )
     * )
     */
    /**
     * Display a listing of companies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CompanyResource::collection(Company::all());
    }
    /**
     * @OA\Get(
     * path="/api/companies/{company}",
     * summary="Get company by id",
     * description="Get company by id",
     * operationId="getCompanyById",
     * tags={"companies"},
     * 
     * @OA\Parameter(
     *    name="company",
     *    description="company id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * ),
     * 
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="")
     *        )
     *     )
     * )
     */
    /**
     * Display the specified company.
     *
     * @param  \App\Models\Company $company
     * @return \App\Models\Company
     */
    public function show(Company $company)
    {
        return $company;
    }
    /**
     * @OA\Get(
     * path="/api/companies/{company}/buildings",
     * summary="Get buildings of a company",
     * description="Get buildings of a company",
     * operationId="getBuildingsOfCompany",
     * tags={"companies"},
     * 
     * @OA\Parameter(
     *    name="company",
     *    description="company id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * ),
     * 
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
     * Display a listing of building for a company.
     *
     * @param  \App\Models\Company $company
     * @return array
     */
    public function buildings(Company $company)
    {
        return BuildingResource::collection($company->buildings);
    }
    /**
     * @OA\Get(
     * path="/api/companies/{company}/buildings/{building}/employees",
     * summary="Get employees per building of a company",
     * description="Get employees per building of a company",
     * operationId="getEmployeesPerBuildingOfCompany",
     * tags={"companies"},
     * 
     * @OA\Parameter(
     *    name="company",
     *    description="company id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
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
     * 
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
     * Display a listing of employees per building for a company.
     *
     * @param  \App\Models\Company $company
     * @param  \App\Models\Building $building
     * @return array
     */
    public function building_employees(Company $company, Building $building)
    {
        return EmployeeResource::collection(
            $building->employees->filter(function ($employee) use ($company) {
                return $employee->company_id == $company->id;
        }));
    }
    /**
     * @OA\Get(
     * path="/api/companies/{company}/employees",
     * summary="Get employees in a company",
     * description="Get employees in a company",
     * operationId="getEmployeesInACompany",
     * tags={"Companies"},
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
     * Display a listing of employees per company.
     *
     * @param  \App\Models\Company $company
     * @return array
     */
    public function employees(Company $company)
    {
        return EmployeeResource::collection($company->employees);
    }
}

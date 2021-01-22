<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use App\Models\Employee;
use App\Models\Building;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Resources\EmployeeDetailed as EmployeeDetailedResource;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeBuildingRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Exception;

class EmployeesController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/employees/{employee}",
     * summary="Get an employee",
     * description="Get an employee",
     * 
     * operationId="getEmployee",
     * tags={"employee"},
     *  @OA\Parameter(
     *    name="employee",
     *    description="employee id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     * @OA\RequestBody(
     *    required=false,
     *    description="employee",
     *    
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     ),
     *  
     *    security={{"bearer":{}}},
     * )
     */
    /**
     * Display information about an employee.
     *
     * @param  \App\Http\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        if ($employee->company_id == auth()->user()->company_id)
            return new EmployeeDetailedResource($employee);

        return new EmployeeResource($employee);
    }

    /**
     * Make sure the specified buildings are allowed for assignment.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @return \Illuminate\Support\Collection|null
     */
    private function CaptureBuildings(EmployeeRequest $request)
    {
        if (!$request->has('buildings'))
            return null;

        // Allow only the buildings that belong to the company
        $allowed = auth()->user()->company->buildings;
        $specified = Building::whereIn('id', $request['buildings'])->get();

        foreach ($specified as $building)
            if (!$allowed->contains($building))
                throw new AuthorizationException('At least one of the specified buildings does not belong to the company.');
    
        return $specified;
    }

    /**
     * Registers a new employee.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(EmployeeRequest $request)
    {
        $buildings = $this->CaptureBuildings($request);

        // Create the employee
        $employee = new Employee($request->only(['name', 'email', 'role']));

        $employee->company_id = auth()->user()->company_id;
        $employee->password = Hash::make($request['password']);
        $employee->save();

        // Assign the buildings
        if ($buildings)
            $employee->buildings()->saveMany($buildings);

        return new EmployeeDetailedResource($employee);
    }
    /**
     * @OA\Put(
     * path="/api/employees/{employee}",
     * summary="Update an existing employee",
     * description="Update an existing employee",
     * operationId="updateEmployee",
     * tags={"employee"},
     *  @OA\Parameter(
     *    name="employee",
     *    description="employee id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="employee",
     *    @OA\JsonContent(
     *       required={"name","email","role","password","buildings"},
     *       @OA\Property(property="name", type="string", format="text", example="testUser1"),
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="role", type="string", format="text", example="ADMIN"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="buildings", type="string", format="text", example="[1]"),
     *       @OA\Property(property="buildings*", type="string", format="array", example=""), 
     *    ),
     *    
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     ),
     *  
     *    security={{"bearer":{}}},
     * )
     */
    /**
     * Update an existing employee.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @param  \App\Http\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        if (!Gate::allows('modify', $employee))
            throw new AuthorizationException();

        $buildings = $this->CaptureBuildings($request);

        $employee->update($request->only(['name', 'email', 'role']));

        //  Change the password
        if ($request->has('password'))
        {
            $employee->password = Hash::make($request['password']);
            $employee->save();
        }

        // Overwrite assigned buildings
        if ($buildings)
        {
            $employee->buildings()->detach();
            $employee->buildings()->saveMany($buildings);
        }

        return new EmployeeDetailedResource($employee);
    }
    /**
     * @OA\Delete(
     * path="/api/employees/{employee}",
     * summary="Delete the specified employee",
     * description="Delete the specified employee",
     * 
     * operationId="deleteEmployee",
     * tags={"employee"},
     *  @OA\Parameter(
     *    name="employee",
     *    description="employee id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * 
     * ),
     * @OA\RequestBody(
     *    required=false,
     *    description="employee",
     *    
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     ),
     *  
     *    security={{"bearer":{}}},
     * )
     */
    /**
     * Delete the specified employee.
     *
     * @param  \App\Http\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if (!Gate::allows('modify', $employee))
            throw new AuthorizationException();

        $employee->buildings()->detach();
        $employee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    /**
     * @OA\Post(
     * path="/api/employees/{employee}/buildings/{building}",
     * summary="Assign an employee to a building",
     * description="Assign an employee to a building",
     * operationId="assignEmployee",
     * tags={"employee"},
     *  @OA\Parameter(
     *    name="employee",
     *    description="employee id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * ),
     * @OA\Parameter(
     *    name="building",
     *    description="building id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * ),
     *    
     * 
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     ),
     *  
     *    security={{"bearer":{}}},
     * )
     */
    /**
     * Assign an employee to a building.
     *
     * @param  \App\Http\Requests\EmployeeBuildingRequest  $request
     * @param  \App\Http\Models\Employee  $employee
     * @param  \App\Http\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function addBuilding(EmployeeBuildingRequest $request, Employee $employee, Building $building)
    {
        if ($employee->company != auth()->user()->company)
            throw new AuthorizationException("The employee does not belong to the company.");

        if (!$employee->company->buildings->contains($building))
            throw new AuthorizationException("The building does not belong to the company.");

        if ($employee->buildings->contains($building))
            throw new Exception("The employee is already assigned to the specified building.");

        $employee->buildings()->attach($building);
        $employee->refresh();

        return new EmployeeDetailedResource($employee);
    }
    /**
     * @OA\Delete(
     * path="/api/employees/{employee}/buildings/{building}",
     * summary="Remove employee's assignment to a building",
     * description="Remove employee's assignment to a building",
     * operationId="unassignEmployee",
     * tags={"employee"},
     *  @OA\Parameter(
     *    name="employee",
     *    description="employee id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *      type="integer"
     *    )
     * ),
     * @OA\Parameter(
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
     *     ),
     *  
     *    security={{"bearer":{}}},
     * )
     */
    /**
     * Remove employee's assignment to a building.
     *
     * @param  \App\Http\Requests\EmployeeBuildingRequest  $request
     * @param  \App\Http\Models\Employee  $employee
     * @param  \App\Http\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function removeBuilding(EmployeeBuildingRequest $request, Employee $employee, Building $building)
    {
        if ($employee->company != auth()->user()->company)
            throw new AuthorizationException("The employee does not belong to the company.");

        if (!$employee->buildings->contains($building))
            throw new Exception("The employee is not assigned to the specified building.");

        if ($employee->visits()->where('building_id', $building->id)->
            where('checked_out_at', null)->exists())
            throw new Exception("The employee has ongoing visits in the building.");

        $employee->buildings()->detach($building);
        $employee->refresh();

        return new EmployeeDetailedResource($employee);
    }
}

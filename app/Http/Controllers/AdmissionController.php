<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\AreaResource;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\ClassFeeResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\FeeResource;
use App\Http\Resources\StudentResource;
use App\Models\Address;
use App\Models\Admission;
use App\Models\Area;
use App\Models\Classes;
use App\Models\ClassFee;
use App\Models\District;
use App\Models\Division;
use App\Models\Fee;
use App\Models\Guardian;
use App\Models\PayableFee;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    public function index()
    {
        $collections = Admission::query()
            ->admission()
            ->with('student.father_info');

        return Inertia::render('Admission/Index', [
            'data' => [
                'collections'   => AdmissionResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Admission/Create', [
            'data' => $this->data(new Admission())
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $student = Student::create(
            $this->validatedStudentData($request)
            + $this->storeGuardian($request)
            + $this->storeAddress($request)
        );

        $admission = $student->admissions()->create(
            $this->validatedAdmissionData($request)
            + $this->getArrayOfSession($request->session)
        );

        $admission->update([
            'application_date' => Http::get(url("/api/date-to-hijri-date/{$admission->created_at->format('d-m-Y')}"))
        ]);

        return redirect()
            ->route('admissions.show', $admission->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Admission $admission)
    {
        $student = $admission->student()->first();

        AdmissionResource::withoutWrapping();

        return Inertia::render('Admission/Show', [
            'data' => [
                'admission' => $this->formatedData($admission),
                'student'   => $this->formatedStudentData($student),
            ]
        ]);
    }

    public function edit(Admission $admission)
    {
        $admission->load('verified_by_admin:id,name');

        $step = (int) (request()->step ?? 1);

        return Inertia::render('Admission/Edit', [
            'data'  => $this->data($admission),
            'step'  => $step,
        ]);
    }

    public function update(Request $request, Admission $admission)
    {
        if($request->step == 1) {
            $student = $admission->student()->first();

            $student->update(
                $this->validatedStudentData($request, $student->id)
                + $this->storeGuardian($request, $student)
                + $this->storeAddress($request, $student)
            );

            $admission->update($this->validatedAdmissionData($request, $admission->id));

            return redirect()
                ->route('admissions.show', $admission->id)
                ->with('status', 'The record has been update successfully.');
        }

        if($request->step == 2) {
            $admission->update([
                "verified_by"           => Auth::id(),
                "admission_test_mark"   => $request->admission_test_mark,
                "verifications"         => json_encode($request->verifications),
                "status"                => 2,
            ]);

            return redirect()
                ->route('admissions.edit', [$admission->id, 'step=3'])
                ->with('status', 'The record has been update successfully.');
        }

        if($request->step == 3) {
            $admission->update([
                "completed_by"  => Auth::id(),
                "concessions"   => json_encode($request->fees),
                "status"        => 3,
            ]);

            return redirect()
                ->route('admissions.edit', [$admission->id, 'step=4'])
                ->with('status', 'The record has been update successfully.');
            
        }

        if($request->step == 4) {

            $new_roll = $this->getNewClassRoll($admission->class_id);

            $admission->update([
                "roll"      => $new_roll,
                "status"    => 4,
            ]);

            if($admission->student->status == 2) {
                $current_year = explode("-", $this->getCurrentSession())[0];
    
                $two_digit_class_code = str_pad($admission->class_id, 2,"0", STR_PAD_LEFT);
    
                $three_digit_roll = str_pad($new_roll, 3,"0", STR_PAD_LEFT);

                $admission->student()->update([
                    "registration"  => $current_year . $two_digit_class_code . $three_digit_roll,
                    "status"        => 1,
                ]);
            }

            return redirect()
                ->route('students.class.show', $admission->class_id)
                ->with('status', 'The record has been update successfully.');
        }

        if($request->step == 5) {
            if($request->class_id != $admission->class_id) {
                $admission->update([
                    'class_id'  => $request->class_id,
                    'roll'      => $this->getNewClassRoll($request->class_id),
                ]);
            }

            return redirect()
                ->route('students.show', $admission->student_id)
                ->with('status', 'The record has been update successfully.');
        }
    }

    public function destroy(Admission $admission)
    {
        // $admission->delete();

        return redirect()
            ->route('admissions.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($admission)
    {
        $student = $admission->student()->first() ?? new Student();
    
        return [
            'admission'     => $this->formatedData($admission),
            'student'       => $this->formatedStudentData($student),
            'divisions'     => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts'     => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'         => AreaResource::collection(Area::orderBy('name')->get()),
            'classes'       => ClassesResource::collection(Classes::get()),
            'bloodGroups'   => Student::getBloodGroups(),
            'residentArray' => Student::getResidentArrayData(),
            'yearlyFees'    => $this->getClassFee($admission->class_id, 1, $student->resident),
            'monthlyFees'   => $this->getClassFee($admission->class_id, 2, $student->resident),
        ];
    }

    protected function formatedData($admission)
    {
        AdmissionResource::withoutWrapping();

        return new AdmissionResource($admission);
    }

    protected function formatedStudentData($student)
    {
        StudentResource::withoutWrapping();

        return new StudentResource(
            $student->load([
                'father_info',
                'mother_info',
                'guardian_info',
                'present_address.area.district',
                'permanent_address.area.district',
            ]
        ));
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    protected function validatedStudentData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'date_of_birth' => '',
            'gender' => '',
            'resident' => [
                'required',
            ],
            'blood_group' => '',
            'birth_certificate' => '',
        ]);
    }

    protected function validatedAdmissionData($request, $id = '')
    {
        return $request->validate([
            // 'session' => [
            //     'required',
            //     'string',
            // ],
            'class_id' => [
                'required',
                'numeric',
            ],
            'previous_school' => [],
            'previous_class' => [],
            'previous_roll' => [],
            'previous_result' => [],
        ]);
    }

    protected function storeGuardian($request, $student = null)
    {
        if($student) {
            Guardian::query()
                ->whereIn('id', [
                    $student->father_info_id,
                    $student->mother_info_id,
                    $student->guardian_info_id
                ])
                ->delete();
        }

        $father_info_id = $this->storeGuardianGetId($request->father_info);

        $mother_info_id = $this->storeGuardianGetId($request->mother_info);

        if ($request->guardian_type == 1) {
            $guardian_info_id = $father_info_id;
        } 
        elseif ($request->guardian_type == 2) {
            $guardian_info_id = $mother_info_id;
        }
        else {
            $guardian_info_id = $this->storeGuardianGetId($request->guardian_info);
        }

        return [
            'father_info_id'    => $father_info_id,
            'mother_info_id'    => $mother_info_id,
            'guardian_info_id'  => $guardian_info_id,
        ];
    }

    protected function storeAddress($request, $student = null)
    {
        if($student) {
            Address::query()
                ->whereIn('id', [
                    $student->present_address_id,
                    $student->permanent_address_id
                ])
                ->delete();
        }

        $present_address_id = $this->storeAddressGetId($request->present_address);

        $permanent_address_id = $request->is_same_address
            ? $present_address_id
            : $this->storeAddressGetId($request->permanent_address);

        return [
            'present_address_id'    => $present_address_id,
            'permanent_address_id'  => $permanent_address_id,
        ];
    }

    protected function storeGuardianGetId($guardian, $old_id = '')
    {
        $response = Guardian::onlyTrashed()->updateOrCreate(
            [],
            [
                'name'          => $guardian['name'] ?? null,
                'phone'         => $guardian['phone'] ?? null,
                'occupation'    => $guardian['occupation'] ?? null,
                'relation'      => $guardian['relation'] ?? null,
                'deleted_at'    => null,
            ]
        );

        return $response->id ?? null;
    }

    protected function storeAddressGetId($address, $old_id = '')
    {
        if($old_id) {
            Address::where('id', $old_id)->delete();
        }

        $response = Address::onlyTrashed()->updateOrCreate(
            [],
            [
                'area_id'       => $address['area'] ?? null,
                'value'         => $address['address'] ?? null,
                'postoffice'    => $address['postoffice'] ?? null,
                'deleted_at'    => null,
            ]
        );

        return $response->id ?? null;
    }

    protected function getNewClassRoll($class_id, $session = null)
    {
        return  $this->getLastClassRoll($class_id, $session) + 1;
    }

    protected function getLastClassRoll($class_id, $session = null)
    {
        $session = $session_id ?? $this->getCurrentSession();

        $last_class_roll = Admission::query()
            ->where([
                'class_id'      => $class_id,
                'session'       => $session
            ])
            ->max('roll');

        return $last_class_roll ?? 0;
    }

    protected function getArrayOfSession($session = null)
    {
        return [
            "session" => $session ?? $this->getCurrentSession()
        ];
    }

    protected function getClassFee($class_id, $period = null, $resident = null)
    {
        ClassFeeResource::withoutWrapping();

        $query = ClassFee::query()
            ->where('class_id', $class_id)
            ->where(function ($query) use ($period) {
                $query->when($period, function ($query) use ($period) {
                    $query->whereHas('fee', function ($query) use ($period) {
                        $query->where('period', $period);
                    });
                });
            });
        
        $class_fees = $query->get();

        if($resident) {
            $class_fees = $class_fees->filter(function ($class_fee) use ($resident) {
                return in_array($resident, json_decode($class_fee->package));
            });
        }

        return ClassFeeResource::collection($class_fees);
    }

}
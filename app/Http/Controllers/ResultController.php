<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ResultResource;
use App\Http\Resources\SubjectResource;
use App\Models\Admission;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResultController extends Controller
{
    
    public function exams()
    {
        $collections = Exam::query()
            ->current()
            ->latest();

        ExamResource::withoutWrapping();

        return Inertia::render('Result/Exam', [
            'data' => [
                'exams' => ExamResource::collection($collections->get()),
            ]
        ]);
    }

    public function finalClasses()
    {
        ClassesResource::withoutWrapping();

        return Inertia::render('Result/FinalClass', [
            'data' => [
                'classes'   => ClassesResource::collection(Classes::with(['subjects', 'exams'])->has('exams')->get()),
            ]
        ]);
    }

    public function classes(Exam $exam)
    {
        if($exam->academic_session !== request()->session) {
            return redirect()->route('results.classes', [
                $exam->id,
                'session' => $exam->academic_session,
            ]);
        }

        ClassesResource::withoutWrapping();

        return Inertia::render('Result/Class', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'classes'   => ClassesResource::collection($exam->classes()->with('subjects')->get()),
            ]
        ]);
    }
    
    public function finalSubjects(Classes $class)
    {
        $class->load('exams');

        // return $class;

        $exams = $class->exams;

        // return $exams;

        ClassesResource::withoutWrapping();
        SubjectResource::withoutWrapping();
        ResultResource::withoutWrapping();

        $optional_subject_code = $class->optional_subject_code;

        $admissions = Admission::query()
            ->with([
                'student:id,name',
            ])
            ->student()
            ->current()
            ->where([
                'class_id' => $class->id,
            ])
            ->orderBy('roll')
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
            ]);
        

        $final_results = [];

        foreach($exams as $exam) {
            // return
            $results = Result::query()
            ->where([
                'exam_id'   => $exam->id,
                'class_id'  => $class->id,
            ])
            ->get();

            foreach($results as $result) {
                foreach($result->marks as $mark) {
                    // if($mark['writing'] == null && $mark['speaking'] == null) {
                    //     continue;
                    // }

                    if(!isset($final_results[$exam->id][$mark['student_id']][$result->subject_code])) {
                        $final_results[$exam->id][$mark['student_id']][$result->subject_code] = 0;
                    }

                    $final_results[$exam->id][$mark['student_id']][$result->subject_code] += (int) ($mark['writing'] ?? 0);
                    $final_results[$exam->id][$mark['student_id']][$result->subject_code] += (int) ($mark['speaking'] ?? 0);
                }
            }

            // dd($final_results);

        }
        
        // foreach($final_results as $final_result) {
        //     dd(array_sum($final_result));
        // }

        // return $final_results;

        $students = $admissions->map(function ($admission) use ($final_results, $optional_subject_code, $exams) {
            $result = [];
            $total = 0;

            foreach($final_results as $exam_id => $final_result) {
                $result[$exam_id] = $final_result[$admission->student->id] ?? [];

                $parcent = $exams->where('id', $exam_id)->first()->final_result_parcent;

                $exam_total = array_sum($final_result[$admission->student->id] ?? []);

                $result[$exam_id]["exam_total"] = $exam_total;

                $total += round(($exam_total / 100) * $parcent);
            }

            return [
                "id"        => $admission->student->id,
                "name"      => $admission->student->name,
                "roll"      => $admission->roll,
                "total"     => $total,
                "result"    => $result,
            ];
        });

        // return $students;

        $students = $students->toArray();
        
        usort($students, function($a, $b) {
            return strcmp($b['total'], $a['total']);
        });

        // return $students;

        $principal = Staff::query()
            ->with('signature')
            ->principal()
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        // return $students;

        return Inertia::render('Result/FinalSubject', [
            'data' => [
                'exams'     => $exams,
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
                'students'  => $students,
                'results'   => $results,
            ],
            'signature' => $signature,
        ]);
    }
    
    public function subjects(Exam $exam, Classes $class)
    {
        ClassesResource::withoutWrapping();
        SubjectResource::withoutWrapping();
        ResultResource::withoutWrapping();

        $optional_subject_code = $class->optional_subject_code;

        $admissions = Admission::query()
            ->with([
                'student:id,name',
            ])
            ->student()
            ->current()
            ->where([
                'class_id' => $class->id,
            ])
            ->orderBy('roll')
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
            ]);

        // return
        $results = Result::query()
            ->where([
                'exam_id'   => $exam->id,
                'class_id'  => $class->id,
            ])
            ->get();

        $final_results = [];

        foreach($results as $result) {
            foreach($result->marks as $mark) {
                // if($mark['writing'] == null && $mark['speaking'] == null) {
                //     continue;
                // }

                if(!isset($final_results[$mark['student_id']][$result->subject_code])) {
                    $final_results[$mark['student_id']][$result->subject_code] = 0;
                }

                $final_results[$mark['student_id']][$result->subject_code] += (int) ($mark['writing'] ?? 0);
                $final_results[$mark['student_id']][$result->subject_code] += (int) ($mark['speaking'] ?? 0);
            }
        }

        // foreach($final_results as $final_result) {
        //     dd(array_sum($final_result));
        // }

        // return $final_results;

        $students = $admissions->map(function ($admission) use ($final_results, $optional_subject_code) {
            return [
                "id"        => $admission->student->id,
                "name"      => $admission->student->name,
                "roll"      => $admission->roll,
                "total"     => array_sum($final_results[$admission->student->id] ?? []),
                "result"    => $final_results[$admission->student->id] ?? [],
            ];
        });

        // return $students->sortBy('total');
        $students = $students->toArray();
        
        usort($students, function($a, $b) {
            return strcmp($b['total'], $a['total']);
        });

        // return $students;

        $principal = Staff::query()
            ->with('signature')
            ->principal()
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        // return $students;

        return Inertia::render('Result/Subject', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
                'students'  => $students,
                'results'   => $results,
            ],
            'signature' => $signature,
        ]);
    }

    private function getAverage($marks, $optional_subject_code)
    {
        unset($marks[$optional_subject_code]);

        $total_subject = count($marks);

        return $total_subject
            ? round(array_sum($marks) / $total_subject, 2)
            : 0;
    }

    public function finalResultCard (Classes $class)
    {
        $class->load([
            'exams',
            'subjects',
        ]);

        // return $class;

        $exams = $class->exams;

        // return $exams;

        ClassesResource::withoutWrapping();
        SubjectResource::withoutWrapping();
        ResultResource::withoutWrapping();

        $optional_subject_code = $class->optional_subject_code;

        $admissions = Admission::query()
            ->with([
                'student:id,name,registration',
            ])
            ->student()
            ->current()
            ->where([
                'class_id' => $class->id,
            ])
            ->orderBy('roll')
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
            ]);
        

        $final_results = [];

        foreach($exams as $exam) {
            // return
            $results = Result::query()
            ->where([
                'exam_id'   => $exam->id,
                'class_id'  => $class->id,
            ])
            ->get();

            foreach($results as $result) {
                foreach($result->marks as $mark) {
                    // if($mark['writing'] == null && $mark['speaking'] == null) {
                    //     continue;
                    // }

                    if(!isset($final_results[$exam->id][$mark['student_id']][$result->subject_code])) {
                        $final_results[$exam->id][$mark['student_id']][$result->subject_code] = 0;
                    }

                    $final_results[$exam->id][$mark['student_id']][$result->subject_code] += (int) ($mark['writing'] ?? 0);
                    $final_results[$exam->id][$mark['student_id']][$result->subject_code] += (int) ($mark['speaking'] ?? 0);
                }
            }

            // dd($final_results);

        }
        
        // foreach($final_results as $final_result) {
        //     dd(array_sum($final_result));
        // }

        // return $final_results;

        $students = $admissions->map(function ($admission) use ($final_results, $optional_subject_code, $exams) {
            $result = [];
            $total = 0;

            foreach($final_results as $exam_id => $final_result) {
                $result[$exam_id] = $final_result[$admission->student->id] ?? [];

                $parcent = $exams->where('id', $exam_id)->first()->final_result_parcent;

                $exam_total = array_sum($final_result[$admission->student->id] ?? []);

                $result[$exam_id]["exam_total"] = $exam_total;

                $total += round(($exam_total / 100) * $parcent);
            }

            return [
                "id"            => $admission->student->id,
                "name"          => $admission->student->name,
                "roll"          => $admission->roll,
                "registration"  => $admission->student->registration,
                "total"         => $total,
                "result"        => $result,
            ];
        });

        // return $students;

        $students = $students->toArray();
        
        usort($students, function($a, $b) {
            return strcmp($b['total'], $a['total']);
        });

        // return $students;

        $principal = Staff::query()
            ->with('signature')
            ->principal()
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        // return $students;

        return Inertia::render('Result/FinalResultCard', [
            'data' => [
                'exams'     => $exams,
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
                'students'  => $students,
                'results'   => $results,
            ],
            'signature' => $signature,
        ]);
    }

    public function resultCard(Exam $exam, Classes $class)
    {
        // return
        $admissions = Admission::query()
            ->with([
                'student:id,name,registration',
            ])
            ->student()
            ->current()
            ->where([
                'class_id' => $class->id,
            ])
            ->orderBy('roll')
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
                'session',
            ]);

        // return
        $subjectwise_results = Result::query()
            ->where([
                'exam_id'   => $exam->id,
                'class_id'  => $class->id,
            ])
            ->get();
            
        $studentwise_results = [];

        foreach($subjectwise_results as $result) {

            foreach($result->marks as $mark) {
                $studentwise_results[$mark["student_id"]][$result->subject_code] = [
                    'writing'       => $mark["writing"],
                    'speaking'      => $mark["speaking"],
                ];
            }

        }

        // return $studentwise_results;   

        $students = $admissions->map(function ($admission) use ($studentwise_results, $subjectwise_results) {
            
            //dd($studentwise_results[$admission->student_id]);

            if(isset($studentwise_results[$admission->student_id])) {
                $results = $studentwise_results[$admission->student_id];
            } else {
                $results = [];

                foreach($subjectwise_results as $result) {
                    $results[$result->subject_code] = [
                        'writing'   => 0,
                        'speaking'  => 0,
                    ];
                }

                // dd($results);
            }

            return [
                "id"            => $admission->student_id,
                "name"          => $admission->student->name,
                "roll"          => $admission->roll,
                "results"       => $results,
                "registration"  => $admission->student->registration,
            ];
        });

        // return $students;

        $principal = Staff::query()
            ->with('signature')
            ->principal()
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';
        
        ClassesResource::withoutWrapping();
        SubjectResource::withoutWrapping();
        ResultResource::withoutWrapping();

        return Inertia::render('Result/ResultCard', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
                'students'  => $students,
                'results'   => $subjectwise_results,
            ],
            'signature' => $signature,
        ]);
    }

    public function create(Exam $exam, Classes $class, $subject_code)
    {
        $class->load([
            'subjects:id,class_id,name,book',
        ]);

        $subject = $class->subjects
            ->where('code', $subject_code)
            ->first() ?? abort(404);

        // return
        $admissions = Admission::query()
            ->with([
                'student:id,name',
            ])
            ->student()
            ->current()
            ->orderBy('roll')
            ->where([
                'class_id' => $class->id,
            ])
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
            ]);

        $class_student_ids = [];
        $result_student_ids = [];

        // return
        $students = $admissions->map(function ($admission) use (&$class_student_ids) {
            array_push($class_student_ids, $admission->student->id);

            return [
                "id"    => $admission->student->id,
                "name"  => $admission->student->name,
                "roll"  => $admission->roll,
            ];
        });

        $marks = [];

        foreach($students as $student) {
            $marks[] = [
                'student_id'    => $student['id'],
                'writing'       => "",
                'speaking'      => "",
            ];
        }

        // return $marks;

        $result = Result::query()
            ->firstOrCreate(
                [
                    'exam_id'       => $exam->id,
                    'class_id'      => $class->id,
                    'subject_code'  => $subject->code,
                ],
                [
                    'marks'         => $marks,
                ]
            );

        $result->load([
            'exam:id,name,session',
            'class:id,name',
        ]);

        foreach($result->marks as $mark) {
            array_push($result_student_ids, $mark["student_id"]);
        }

        // return compact('class_student_ids', 'result_student_ids');

        // return
        $diff_ids = array_diff($class_student_ids, $result_student_ids);

        if(count($diff_ids)) {
            // return
            $result_marks = $result->marks;

            foreach($diff_ids as $diff_id) {
                array_push($result_marks, [
                    'student_id'    => $diff_id,
                    'writing'       => "",
                    'speaking'      => "",
                ]);
            }

            $result->update(['marks' => $result_marks]);
        }

        // return $result;
        
        $result->subject = $subject;

        ResultResource::withoutWrapping();

        // return ResultResource::make($result);

        return Inertia::render('Result/Create', [
            'data' => [
                'result'    => ResultResource::make($result),
                'students'  => $students,
            ]
        ]);
    }

    public function store(Request $request, Exam $exam, Classes $class, $subject_code)
    {
        $result = Result::query()
            ->where([
                'exam_id'       => $exam->id,
                'class_id'      => $class->id,
                'subject_code'  => $subject_code,
            ])->firstOrFail();

        $result->update([
            'marks' => $request->result["marks"],
        ]);

        $result->load('exam');

        return redirect()->route('results.subjects', [
            $exam->id,
            $class->id,
            'session' => substr($result->exam->session ?? "", -5, 5),
        ]);
    }
}

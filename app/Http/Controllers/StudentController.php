<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
  public function index($pagination = null, $filters = null, $sort = null)
  {
    try {
      $students = Student::query()
        ->with([
          'user',
          'level',
          'subjects',
        ])
        ->when($filters != null, function ($query) use ($filters) {
          $query->filterStudent($filters);
        })
        ->when($sort != null, function ($query) use ($sort) {
          $query->sortStudent($sort);
        });

      if ($pagination != null) {
        $inputs = request()->input();
        $students = $students->paginate($pagination)->withQueryString();
      } else {
        $students = $students->get();
      }

      $students = getResourceResponse(
        request(),
        'Student',
        'Collection',
        $students
      );

      request()->flash();

      return [
        'message' => 'success',
        'data' => [
          'students' => $students,
        ],
      ];
    } catch (\Exception $e) {
      return [
        'message' => 'fail',
        'errors' => [
          $e->getMessage(),
        ],
      ];
    }
  }

  public function create()
  {
    //
  }

  public function store(StoreStudentRequest $request)
  {
    try {
      $validator = Validator::make(
        $request->all(),
        $request->rules(),
        $request->messages(),
        $request->attributes()
      );

      if ($validator->fails()) {
        $request->flash();

        return [
          'message' => 'fail',
          'errors' => $validator->getMessageBag()->all(),
        ];
      }

      $validated_data = $validator->validated();

      $student = Student::create($validated_data);

      return [
        'message' => 'success',
      ];
    } catch (\Exception $e) {
      $request->flash();

      return [
        'message' => 'fail',
        'errors' => [
          $e->getMessage(),
        ],
      ];
    }
  }

  public function show(Student $student)
  {
    try {
      $student = getResourceResponse(
        request(),
        'Student',
        'ShowResource',
        $student
      );

      return [
        'message' => 'success',
        'data' => [
          'student' => $student,
        ],
      ];
    } catch (\Exception $e) {
      return [
        'message' => 'fail',
        'errors' => [
          $e->getMessage(),
        ],
      ];
    }
  }

  public function edit(Student $student)
  {
    try {
      $student = getResourceResponse(
        request(),
        'Student',
        'ShowResource',
        $student
      );

      return [
        'message' => 'success',
        'data' => [
          'student' => $student,
        ],
      ];
    } catch (\Exception $e) {
      return [
        'message' => 'fail',
        'errors' => [
          $e->getMessage(),
        ],
      ];
    }
  }

  public function update(UpdateStudentRequest $request, Student $student)
  {
    try {
      $validator = Validator::make(
        $request->all(),
        $request->rules(),
        $request->messages(),
        $request->attributes()
      );

      $messages = [];

      if ($validator->fails()) {
        $request->flash();

        return [
          'message' => 'fail',
          'errors' => $validator->getMessageBag()->all(),
        ];
      }

      $validated_data = $validator->validated();

      $student->update($validated_data);

      return [
        'message' => 'success',
        'messages' => $messages,
      ];
    } catch (\Exception $e) {
      $request->flash();

      return [
        'message' => 'fail',
        'errors' => [
          $e->getMessage(),
        ],
      ];
    }
  }

  public function destroy(Student $student)
  {
    try {
      $student->delete();

      return [
        'message' => 'success',
      ];
    } catch (\Exception $e) {
      return [
        'message' => 'fail',
        'errors' => [
          $e->getMessage(),
        ],
      ];
    }
  }
}

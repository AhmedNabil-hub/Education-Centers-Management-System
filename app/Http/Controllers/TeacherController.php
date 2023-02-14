<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;


class TeacherController extends Controller
{
  public function index($pagination = null, $filters = null, $sort = null)
  {
    try {
      $teachers = Teacher::query()
        ->with([
          'subject',
        ])
        ->when($filters != null, function ($query) use ($filters) {
          $query->filterTeacher($filters);
        })
        ->when($sort != null, function ($query) use ($sort) {
          $query->sortTeacher($sort);
        });

      if ($pagination != null) {
        $inputs = request()->input();
        $teachers = $teachers->paginate($pagination)->withQueryString();
      } else {
        $teachers = $teachers->get();
      }

      $teachers = getResourceResponse(
        request(),
        'Teacher',
        'Collection',
        $teachers
      );

      request()->flash();

      return [
        'message' => 'success',
        'data' => [
          'teachers' => $teachers,
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

  public function store(StoreTeacherRequest $request)
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

      $teacher = Teacher::create($validated_data);

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

  public function show(Teacher $teacher)
  {
    try {
      $teacher = getResourceResponse(
        request(),
        'Teacher',
        'ShowResource',
        $teacher
      );

      return [
        'message' => 'success',
        'data' => [
          'teacher' => $teacher,
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

  public function edit(Teacher $teacher)
  {
    try {
      $teacher = getResourceResponse(
        request(),
        'Teacher',
        'ShowResource',
        $teacher
      );

      return [
        'message' => 'success',
        'data' => [
          'teacher' => $teacher,
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

  public function update(UpdateTeacherRequest $request, Teacher $teacher)
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

      $teacher->update($validated_data);

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

  public function destroy(Teacher $teacher)
  {
    try {
      $teacher->delete();

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

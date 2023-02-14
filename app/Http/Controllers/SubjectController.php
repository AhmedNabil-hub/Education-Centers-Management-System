<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
  public function index($pagination = null, $filters = null, $sort = null)
  {
    try {
      $subjects = Subject::query()
        ->with([
          'user',
          'teacher',
          'students',
          'levels',
        ])
        ->when($filters != null, function ($query) use ($filters) {
          $query->filterSubject($filters);
        })
        ->when($sort != null, function ($query) use ($sort) {
          $query->sortSubject($sort);
        });

      if ($pagination != null) {
        $inputs = request()->input();
        $subjects = $subjects->paginate($pagination)->withQueryString();
      } else {
        $subjects = $subjects->get();
      }

      $subjects = getResourceResponse(
        request(),
        'Subject',
        'Collection',
        $subjects
      );

      request()->flash();

      return [
        'message' => 'success',
        'data' => [
          'subjects' => $subjects,
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

  public function store(StoreSubjectRequest $request)
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

      $subject = Subject::create($validated_data);

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

  public function show(Subject $subject)
  {
    try {
      $subject = getResourceResponse(
        request(),
        'Subject',
        'ShowResource',
        $subject
      );

      return [
        'message' => 'success',
        'data' => [
          'subject' => $subject,
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

  public function edit(Subject $subject)
  {
    try {
      $subject = getResourceResponse(
        request(),
        'Subject',
        'ShowResource',
        $subject
      );

      return [
        'message' => 'success',
        'data' => [
          'subject' => $subject,
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

  public function update(UpdateSubjectRequest $request, Subject $subject)
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

      $subject->update($validated_data);

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

  public function destroy(Subject $subject)
  {
    try {
      $subject->delete();

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

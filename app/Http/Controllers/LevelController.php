<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
  public function index($pagination = null, $filters = null, $sort = null)
  {
    try {
      $levels = Level::query()
        ->with([
          'students',
          'subjects',
          'users',
        ])
        ->when($filters != null, function ($query) use ($filters) {
          $query->filterLevel($filters);
        })
        ->when($sort != null, function ($query) use ($sort) {
          $query->sortLevel($sort);
        });

      if ($pagination != null) {
        $inputs = request()->input();
        $levels = $levels->paginate($pagination)->withQueryString();
      } else {
        $levels = $levels->get();
      }

      $levels = getResourceResponse(
        request(),
        'Level',
        'Collection',
        $levels
      );

      request()->flash();

      return [
        'message' => 'success',
        'data' => [
          'levels' => $levels,
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

  public function store(StoreLevelRequest $request)
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

      $level = Level::create($validated_data);

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

  public function show(Level $level)
  {
    try {
      $level = getResourceResponse(
        request(),
        'Level',
        'ShowResource',
        $level
      );

      return [
        'message' => 'success',
        'data' => [
          'level' => $level,
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

  public function edit(Level $level)
  {
    try {
      $level = getResourceResponse(
        request(),
        'Level',
        'ShowResource',
        $level
      );

      return [
        'message' => 'success',
        'data' => [
          'level' => $level,
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

  public function update(UpdateLevelRequest $request, Level $level)
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

      $level->update($validated_data);

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

  public function destroy(Level $level)
  {
    try {
      $level->delete();

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

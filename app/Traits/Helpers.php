<?php

use App\Models\Mediafile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\MediafileController;

function getResourceResponse(Request $request, $model, $data_type, $data)
{
  $type = ucfirst(str_contains($request->route()->getPrefix() ?? '', 'admin') ? 'admin' : 'front');
  $model = ucfirst($model);
  if (!in_array($data_type, ['Collection', 'IndexResource', 'ShowResource'])) {
    return false;
  }

  $path = "App\\Http\\Resources\\$type\\$model\\";

  $obj_name = $path . $model . $data_type;

  return json_decode(json_encode(new $obj_name($data)));
}

function array_depth(array $array)
{
  $max_depth = 1;

  foreach ($array as $value) {
    if (is_array($value)) {
      $depth = array_depth($value) + 1;

      if ($depth > $max_depth) {
        $max_depth = $depth;
      }
    }
  }

  return $max_depth;
}

function mediafilesManage($method, array $mediafiles)
{
  $mediafile_controller = new MediafileController();

  foreach ($mediafiles as $mediafile) {
    $mediafile_data = [
      'mediafile' => $mediafile['mediafile'],
      'mediafile_type' => $mediafile['mediafile_type'],
      'model_id' => $mediafile['model_id'],
      'model_type' => $mediafile['model_type'],
      'is_default' => $mediafile['is_default'],
    ];

    if ($method == 'store') {
      $mediafile_response = $mediafile_controller->store($mediafile_data);
    } elseif ($method == 'update') {
      $mediafile_response = $mediafile_controller->update($mediafile_data, $mediafile['id']);
    } elseif ($method == 'destroy') {
      $mediafile_response = $mediafile_controller->destroy($mediafile['id'], $mediafile['mediafile_type']);
    }

    if ($mediafile_response['message'] == 'fail') {
      $errors[] = $mediafile_response['errors'];
    }
  }

  return $errors ?? 'success';
}

function mediafilePrepare($mediafile, $mediafile_type)
{
  $specs = Mediafile::TYPE[$mediafile_type];

  $img = Image::make($mediafile)
    ->resize($specs['width'], $specs['height'], function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    })
    // ->fit($specs['width'], $specs['height'])
    ->encode($specs['ext'], 75);

  $img_name = md5(time()) . '.' . $specs['ext'];

  return [
    'img' => $img,
    'img_name' => $img_name,
  ];
}

function mediafileUploadDefault($mediafile_data)
{
  $path = 'uploads/' . $mediafile_data['model_type'] . '/' . $mediafile_data['mediafile_type'];
  $path = $path . '/' . Mediafile::DEFAULT_IMAGE_NAME[$mediafile_data['model_type']];

  return [
    'path' => $path,
    'type' => $mediafile_data['mediafile_type'],
    'model_type' => $mediafile_data['model_type'],
    'model_id' => $mediafile_data['model_id'],
    'is_default' => 1,
  ];
}

function mediafileUpload($mediafile_data)
{
  try {
    $path = 'uploads/' . $mediafile_data['model_type'] . '/' . $mediafile_data['mediafile_type'];

    $prepared_img = mediafilePrepare(
      $mediafile_data['mediafile'],
      $mediafile_data['mediafile_type']
    );

    $path = $path . '/' . $prepared_img['img_name'];

    // Storage::put(
    //   $path,
    //   $prepared_img['img'],
    // );

    $storage = app('firebase.storage');
    $bucket = $storage->getBucket();
    $bucket->upload(
      $prepared_img['img'],
      ['name' => $path]
    );

    return [
      'path' => $path,
      // 'path' => str_replace('', '', $path),
      'type' => $mediafile_data['mediafile_type'],
      'model_type' => $mediafile_data['model_type'],
      'model_id' => $mediafile_data['model_id'],
      'is_default' => 0
    ];
  } catch (\Exception $e) {
    return $e->getMessage();
  }
}

function mediafileDownload($mediafile)
{
  // $url = $mediafile ? config('filesystems.disks.public.url') . $mediafile->path : null;

  $storage = app('firebase.storage');
  $bucket = $storage->getBucket();
  $object = $bucket->object($mediafile->path);
  $url = $object->signedUrl(now()->addHour());

  return $url;
}

function defaultUserProfileMediafileCreate($user_id)
{
  $mediafile_data = [
    'model_type' => 'user',
    'mediafile_type' => 'profile_image',
    'model_id' => $user_id,
  ];

  $mediafile = mediafileUploadDefault($mediafile_data);

  Mediafile::create($mediafile);

  return 'success';
}

function getDataBaseTableColumn($table, $column, $column_as, $clause = [])
{
  $data = DB::table($table)
    ->select($column . ' as ' . $column_as)
    ->when($clause, function ($query, $clause) {
      return $query->where($clause['column'], $clause['value']);
    })
    ->distinct()
    ->orderBy($column)
    ->get();

  return $data;
}

function getPrevRouteName()
{
  $prev = url()->previous();
  $route = app('router')->getRoutes()->match(app('request')->create($prev));

  return $route->action['as'];
}

function generatePermissionsNames()
{
  $loader = require base_path('vendor/autoload.php');
  $admin = [];
  $main = [];

  foreach ($loader->getClassMap() as $class => $file) {
    if (
      preg_match('/[a-z]+Controller$/', $class) &&
      !in_array($class, ['HomeController', 'AdminController', 'MainController'])
    ) {
      $reflection = new ReflectionClass($class);
      // $methods = [];
      $class_name = explode('\\', $class);

      // exclude inherited methods
      foreach ($reflection->getMethods() as $method) {
        if ($method->class == $reflection->getName() && $method->name != '__construct') {
          if (in_array('Admin', $class_name)) {
            $admin[] = strtolower(str_replace('Controller', '', end($class_name))) . '-' . $method->name;
          } elseif (in_array('Main', $class_name)) {
            $main[] = strtolower(str_replace('Controller', '', end($class_name))) . '-' . $method->name;
          }
        }
      }
    }
  }

  return [
    'admin' => $admin,
    'main' => $main,
  ];
}

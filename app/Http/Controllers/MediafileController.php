<?php

namespace App\Http\Controllers;

use App\Models\Mediafile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MediafileController extends Controller
{
	public function store($mediafile_data)
	{
		try {
			$mediafile = $mediafile_data['is_default'] ?
				mediafileUploadDefault($mediafile_data) :
				mediafileUpload($mediafile_data);

			if (!is_array($mediafile)) {
				return [
					'message' => 'fail',
					'errors' => [
						$mediafile,
					],
				];
			}

			$mediafile = Mediafile::create($mediafile);

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

	public function update($mediafile_data, $id)
	{
		$mediafile_delete_response = $this->destroy($id, $mediafile_data['mediafile_type']);

		if ($mediafile_delete_response['message'] == 'fail') {
			return $mediafile_delete_response;
		}

		$mediafile_store_response = $this->store($mediafile_data);

		if ($mediafile_store_response['message'] == 'fail') {
			return $mediafile_store_response;
		}

		return [
			'message' => 'success',
		];
	}

	public function destroy($id, $type)
	{
		try {
			$mediafile = Mediafile::query()
				->where([
					['id', $id],
					['type', $type],
				])
				?->first();

			if (!isset($mediafile)) {
				return 'You can not delete this mediafile.';
				return [
					'message' => 'fail',
					'errors' => [
						'You can not delete this mediafile.',
					],
				];
			}

			if ($mediafile->is_default != 1) {
				// Storage::delete('public' . $mediafile->path);

				$storage = app('firebase.storage');
				$bucket = $storage->getBucket();
				$object = $bucket->object($mediafile->path);
				$object->delete();
			}

			$mediafile->delete();

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

	public function destroyAll($model_id, $model_type)
	{
		try {
			$mediafiles = Mediafile::where([
				['model_id', '=', $model_id],
				['model_type', '=', $model_type]
			])->get();

			$storage = app('firebase.storage');
			$bucket = $storage->getBucket();

			foreach ($mediafiles as $mediafile) {
				if ($mediafile->is_default != 1) {
					Storage::delete('public' . $mediafile->path);

					$object = $bucket->object($mediafile->path);
					$object->delete();
				}

				$mediafile->delete();
			}

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

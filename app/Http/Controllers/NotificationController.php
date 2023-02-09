<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseMessagingService;

class NotificationController extends Controller
{
	public function index()
	{
		try {
			$resource_response = getResourceResponse(
				request(),
				'notification',
				'Collection',
				auth()->user()
					->notifications
					->sortByDesc('created_at')
					->take(10)
			);

			return response()->json(
				[
					'data' => $resource_response,
					'status' => Response::HTTP_OK,
				],
			);
		} catch (\Exception $e) {
			return response()->json(
				[
					'errors' => [$e->getMessage()],
					'status' => Response::HTTP_NOT_FOUND,
				],
			);
		}
	}

	public function show(Request $request)
	{
		try {
			$validator = Validator::make(
				$request->all(),
				[
					'notification_id' => 'required|exists:notifications,id',
				],
			);

			if ($validator->fails()) {
				return response()->json(
					[
						'errors' => $validator->getMessageBag(),
						'status' => Response::HTTP_NOT_ACCEPTABLE,
					],
				);
			}

			$data = $validator->validated();

			$notification = DB::table('notifications')
				->select('*')
				->where([
					['notifiable_id', auth()->user()->id],
					['id', $data['notification_id']],
				])
				->first();

			$resource_response = getResourceResponse(
				request(),
				'notification',
				'ShowResource',
				$notification
			);

			return response()->json(
				[
					'data' => $resource_response,
					'status' => Response::HTTP_OK,
				],
			);
		} catch (\Exception $e) {
			return response()->json(
				[
					'errors' => [$e->getMessage()],
					'status' => Response::HTTP_NOT_FOUND,
				],
			);
		}
	}

	public function read(Request $request)
	{
		try {
			$validator = Validator::make(
				$request->all(),
				[
					'notification_id' => 'required|exists:notifications,id',
				],
			);

			if ($validator->fails()) {
				return response()->json(
					[
						'errors' => $validator->getMessageBag(),
						'status' => Response::HTTP_NOT_ACCEPTABLE,
					],
				);
			}

			$data = $validator->validated();

			DB::table('notifications')
				->where([
					['notifiable_id', auth()->user()->id],
					['id', $data['notification_id']],
					['read_at', '<>', null]
				])
				->update(['read_at' => now()]);

			return response()->json(
				[
					'messages' => ['Notification read'],
					'status' => Response::HTTP_OK,
				],
			);
		} catch (\Exception $e) {
			return response()->json(
				[
					'errors' => [$e->getMessage()],
					'status' => Response::HTTP_NOT_FOUND,
				],
			);
		}
	}

	public function readAll()
	{
		try {
			DB::table('notifications')
				->where([
					['notifiable_id', auth()->user()->id],
					['read_at', '<>', null]
				])
				->update(['read_at' => now()]);

			return response()->json(
				[
					'messages' => ['Notifications read'],
					'status' => Response::HTTP_OK,
				],
			);
		} catch (\Exception $e) {
			return response()->json(
				[
					'errors' => [$e->getMessage()],
					'status' => Response::HTTP_NOT_FOUND,
				],
			);
		}
	}

	public function destroy(Request $request)
	{
		try {
			$validator = Validator::make(
				$request->all(),
				[
					'notification_id' => 'required|exists:notifications,id',
				],
			);

			if ($validator->fails()) {
				return response()->json(
					[
						'errors' => $validator->getMessageBag(),
						'status' => Response::HTTP_NOT_ACCEPTABLE,
					],
				);
			}

			$data = $validator->validated();

			DB::table('notifications')
				->where([
					['notifiable_id', auth()->user()->id],
					['id', $data['notification_id']],
				])
				->delete();

			return response()->json(
				[
					'messages' => ['Notification deleted'],
					'status' => Response::HTTP_OK,
				],
			);
		} catch (\Exception $e) {
			return response()->json(
				[
					'errors' => [$e->getMessage()],
					'status' => Response::HTTP_NOT_FOUND,
				],
			);
		}
	}

	public function destroyAll()
	{
		try {
			DB::table('notifications')
				->where([
					['notifiable_id', auth()->user()->id],
				])
				->delete();

			return response()->json(
				[
					'messages' => ['Notifications deleted'],
					'status' => Response::HTTP_OK,
				],
			);
		} catch (\Exception $e) {
			return response()->json(
				[
					'errors' => [$e->getMessage()],
					'status' => Response::HTTP_NOT_FOUND,
				],
			);
		}
	}
}

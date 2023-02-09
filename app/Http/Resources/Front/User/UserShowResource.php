<?php

namespace App\Http\Resources\Front\User;

use App\Models\User;
use App\Models\Mediafile;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShowResource extends JsonResource
{
	public function toArray($request)
	{
		$profile_image = $this->mediafile;
		$profile_image = isset($profile_image) ?
			mediafileDownload($profile_image) :
			null;

		return [
			'id' => $this->id,
			'username' => $this->username,
			'full_name' => $this->full_name,
			'status' => User::STATUS[$this->status],
			'gender' => User::GENDER[$this->gender],
			'email' => $this->email,
			'phone' => $this->phone,
			'address' => $this->address,
			'first_time_login' => $this->first_time_login ? 'yes' : 'no',
			'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
			'updated_at' => Carbon::parse($this->updated_at)->format('d-m-Y'),
			'profile_image' => $profile_image,
			'roles' => $this->getRoleNames()->toArray() ?? [],
		];
	}
}

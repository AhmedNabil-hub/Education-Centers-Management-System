<?php

namespace App\Http\Resources\Admin\User;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserIndexResource extends JsonResource
{
  public function toArray($request)
  {
    // $profile_image = $this->mediafile?->first();
		// $profile_image = isset($profile_image) ?
		// 	mediafileDownload($profile_image) :
		// 	null;

    return [
			'id' => $this->id,
			'username' => $this->username,
			// 'full_name' => $this->full_name,
			'status' => User::STATUS[$this->status],
			// 'gender' => ucfirst(User::GENDER[$this->gender]),
			'email' => $this->email,
			'phone' => $this->phone,
			// 'address' => $this->address,
			'roles' => $this->getRoleNames()->toArray() ?? [],
    ];
  }
}

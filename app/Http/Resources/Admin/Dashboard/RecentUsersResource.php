<?php

namespace App\Http\Resources\Admin\Dashboard;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentUsersResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'full_name' => $this->full_name,
      'email' => $this->email,
      'phone' => $this->phone,
      'created' => $this->created_at->diffForHumans(),
    ];
  }
}

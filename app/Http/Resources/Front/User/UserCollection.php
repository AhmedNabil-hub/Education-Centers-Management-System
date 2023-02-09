<?php

namespace App\Http\Resources\Front\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
  public function toArray($request)
  {
    if($this->resource instanceof \Illuminate\Pagination\AbstractPaginator) {
      $pagination = [
				'hasPages' => $this->hasPages(),
				'onFirstPage' => $this->onFirstPage(),
				'previousPageUrl' => $this->previousPageUrl(),
				'hasMorePages' => $this->hasMorePages(),
				'nextPageUrl' => $this->nextPageUrl(),
				'firstItem' => $this->firstItem(),
				'lastItem' => $this->lastItem(),
				'total' => $this->total(),
				'currentPage' => $this->currentPage(),
				'links' => $this->getUrlRange(1, $this->lastPage()),

        // 'count' => $this->count(),
        // 'total' => $this->total(),
        // 'perPage' => $this->perPage(),
        // 'numberOfPages' => $this->lastPage(),
        // 'previousPageUrl' => $this->previousPageUrl(),
        // 'currentPageUrl' => $this->url($this->currentPage()),
        // 'nextPageUrl' => $this->nextPageUrl(),
        // 'links' => $this->getUrlRange(1, $this->lastPage()),
      ];
    }

    return [
      'data' => UserIndexResource::collection($this),
      'pagination' => $pagination ?? null,
    ];
  }
}

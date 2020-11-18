<?php

namespace App\Http\Resources\Site;

use App\Models\SiteSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'contact_message' =>SiteSetting::where('title','Contact')->first()->setting,
            ];
    }
}

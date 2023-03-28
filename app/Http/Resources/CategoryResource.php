<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $allow_deletion = true;

        // check allow deletion
        if($this->type == 1) {
            $allow_deletion = !($this->incomes()->count() ?? 0);
        } elseif($this->type == 2) {
            $allow_deletion = !($this->expenses()->count() ?? 0);
        }

        return [
            'id'            => (int) ($this->id),
            'name'          => (string) ($this->name ?? ''),
            'type'          => (int) ($this->type ?? 0),
            'allowDeletion' => (boolean) ($allow_deletion ?? true),
        ];
    }
}

<?php
namespace Deegitalbe\TrustupVersionedPackage\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VersionedPackage extends JsonResource
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
            'version' => $this->getVersion(),
            'name' => $this->getName()
        ];
    }
}
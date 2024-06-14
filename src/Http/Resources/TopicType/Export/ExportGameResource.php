<?php

namespace EscolaLms\TopicTypes\Http\Resources\TopicType\Export;

use EscolaLms\TopicTypes\Http\Resources\TopicType\Contacts\TopicTypeResourceContract;
use EscolaLms\TopicTypes\Services\TopicTypeService;
use Illuminate\Http\Resources\Json\JsonResource;

class ExportGameResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request)
    {
        return [
            'value' => $this->value,
            'asset_folder' => $this->topic->getKey(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

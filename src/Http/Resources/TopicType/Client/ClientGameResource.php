<?php

namespace EscolaLms\TopicTypes\Http\Resources\TopicType\Client;

use EscolaLms\TopicTypes\Http\Resources\TopicType\Contacts\TopicTypeResourceContract;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ClientGameResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'length' => $this->length,
        ];
    }
}

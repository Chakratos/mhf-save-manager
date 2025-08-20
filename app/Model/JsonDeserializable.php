<?php

namespace MHFSaveManager\Model;

interface JsonDeserializable
{
    public function setFromJson(array $jsonObject);
}

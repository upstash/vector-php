<?php

namespace Upstash\Vector\Enums;

enum UpdateMode: string
{
    case OVERWRITE = 'OVERWRITE';
    case PATCH = 'PATCH';
}

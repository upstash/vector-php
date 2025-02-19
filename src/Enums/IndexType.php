<?php

namespace Upstash\Vector\Enums;

enum IndexType: string
{
    case DENSE = 'DENSE';
    case SPARSE = 'SPARSE';
    case HYBRID = 'HYBRID';
    case UNKNOWN = 'UNKNOWN';
}

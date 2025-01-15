<?php

namespace Upstash\Vector\Enums;

enum QueryMode: string
{
    case HYBRID = 'HYBRID';
    case DENSE = 'DENSE';

    case SPARSE = 'SPARSE';
}

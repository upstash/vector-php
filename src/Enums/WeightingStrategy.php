<?php

namespace Upstash\Vector\Enums;

enum WeightingStrategy: string
{
    case INVERSE_DOCUMENT_FREQUENCY = 'IDF';
}

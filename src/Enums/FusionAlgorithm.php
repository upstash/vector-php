<?php

namespace Upstash\Vector\Enums;

enum FusionAlgorithm: string
{
    case RECIPROCAL_RANK_FUSION = 'RRF';

    case DISTRIBUTION_BASED_SCORE_FUSION = 'DBSF';
}

<?php

namespace App\Enums;

enum Retcode: int
{
    case SUCCESS = 0;

    case CLIENT_ERROR = 9001;
    case NOT_FOUND_ERROR = 9002;
    case CONFLICT_ERROR = 9003;
    case SERVER_ERROR = 9004;
    case UNATHORIZED_ERROR = 9005;
    case FORBIDEN_ERROR = 9006;
    case UNPROCESSABLE_ENTITY_ERROR = 9007;
}

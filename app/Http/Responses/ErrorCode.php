<?php

namespace App\Http\Responses;

enum ErrorCode: string
{
    case AUTH_USER_REGISTER_FAILED = 'A0000';
    case AUTH_USER_FETCH_LIST_FAILED = 'A0001';
    case WALLET_FETCH_FAILED = 'B0000';
}

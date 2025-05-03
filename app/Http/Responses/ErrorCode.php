<?php

namespace App\Http\Responses;

enum ErrorCode: string
{
    case AUTH_USER_REGISTER_FAILED = 'A0000';
    case AUTH_USER_FETCH_LIST_FAILED = 'A0001';
    case AUTH_USER_PROFILE_UPDATE_FAILED = 'B0000';
    case WALLET_FETCH_FAILED = 'C0000';
    case WALLET_WITHDRAWAL_REQUEST_CREATE_FAILED = 'CW01';
}

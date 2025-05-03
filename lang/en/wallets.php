<?php

return [
    'not_found'            => 'Wallet not found',
    'invalid_wallet_id'    => 'Wallet id is not valid',
    'create_wallet_failed' => 'Wallet cannot be created',
    'update_wallet_failed' => 'Wallet cannot be updated',
    'get_wallet_failed'    => 'Cannot get user wallet',
    'insufficient_balance' => 'Insufficient balance',
    'wallet_transaction'   => [
        'increase_failed'  => 'Wallet increase failed',
        'initial_amount'   => 'Wallet initial balance',
        'amount_blocked'   => 'Wallet amount is blocked',
        'amount_unblocked' => 'Wallet amount is unblocked',
        'amount_decreased' => 'Wallet amount is decreased',
        'block_failed'     => 'Cannot log blocked amount in transactions',
        'unblock_failed'   => 'Cannot log unblocked amount in transactions',
        'decrease_failed'  => 'Cannot log decrease amount in transactions',
    ],
    'withdrawals' => [
        'get_list_failed'            => 'Cannot get withdrawal list',
        'cannot_be_created'          => 'Withdrawal request cannot be created',
        'cannot_be_updated'          => 'Withdrawal request cannot be updated',
        'sheba_numbers_are_the_same' => 'Sheba numbers cannot be the same',
        'created_successfully'       => 'Withdrawal request created successfully',
        'confirmed'                  => 'Withdrawal request confirmed successfully',
        'cancelled'                  => 'Withdrawal request canceled',
        'not_found'                  => 'Withdrawal not found',
        'already_confirmed'          => 'Withdrawal is already confirmed',
        'already_canceled'           => 'Withdrawal is already canceled'
    ]
];

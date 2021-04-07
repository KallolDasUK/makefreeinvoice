<?php

use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;

if (!function_exists('openingBalance')) {
    function openingBalance($ledger): int
    {
        return TransactionDetail::query()->where('ledger_id', $ledger->id)->where('note', "OpeningBalance")->sum('amount');
    }
}
if (!function_exists('openingDrBalance')) {
    function openingDrBalance($ledger, $start, $end)
    {
        return TransactionDetail::query()
            ->where('ledger_id', $ledger->id)
            ->where('entry_type', EntryType::$DR)
            ->where('note', 'OpeningBalance')
            ->sum('amount');

    }
}
if (!function_exists('openingCrBalance')) {
    function openingCrBalance($ledger, $start, $end)
    {

    }
}

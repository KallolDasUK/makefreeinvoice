<?php

namespace App\Observers;

use App\Models\PosItem;
use App\Models\PosSale;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Utils\LedgerHelper;

class PosSaleItemObserver
{
    public function created(PosItem $item)
    {
        $pos = $item->pos_sale;
        $product = $item->product;
        if ($product->product_type != 'Goods') return;

        $purchase_price = $product->purchase_price ?? 0;
        $cost_of_goods_sold = $purchase_price * $item->qnt;
        if ($cost_of_goods_sold) {
            AccountingFacade::addTransaction(Ledger::COST_OF_GOODS_SOLD(), Ledger::INVENTORY_AC(), $cost_of_goods_sold, $pos->note,
                $pos->date, 'Expense', PosSale::class, $pos->id,
                $pos->pos_number, LedgerHelper::$COST_OF_GOODS_SOLD);
        }

    }
}

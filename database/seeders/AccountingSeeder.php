<?php

namespace Database\Seeders;


use Enam\Acc\Accounting;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Utils\CashFlowType;
use Enam\Acc\Utils\LedgerHelper;
use Enam\Acc\Utils\Nature;
use Illuminate\Database\Seeder;

class AccountingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        LedgerGroup::query()->delete();
        Ledger::query()->delete();
        GroupMap::query()->delete();
        $lg_ca = LedgerGroup::create(['group_name' => LedgerHelper::$CurrentAsset,
            'parent' => -1,
            'nature' => Nature::$ASSET,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_ca->group_name, 'value' => $lg_ca->id]);


        $lsa = Ledger::create(['ledger_name' => LedgerHelper::$INVENTORY_AC, 'ledger_group_id' => $lg_ca->id, 'is_default' => true]);
        GroupMap::create(['key' => $lsa->ledger_name, 'value' => $lsa->id]);

        $lsa = Ledger::create(['ledger_name' => LedgerHelper::$ADVANCE_TAX, 'ledger_group_id' => $lg_ca->id, 'is_default' => true]);
        GroupMap::create(['key' => $lsa->ledger_name, 'value' => $lsa->id]);

        $lsa = Ledger::create(['ledger_name' => LedgerHelper::$ACCOUNTS_RECEIVABLE, 'ledger_group_id' => $lg_ca->id, 'is_default' => true]);
        GroupMap::create(['key' => $lsa->ledger_name, 'value' => $lsa->id]);


        $lsa = Ledger::create(['ledger_name' => LedgerHelper::$INVENTORY_AC, 'ledger_group_id' => $lg_ca->id, 'is_default' => true]);
        GroupMap::create(['key' => $lsa->ledger_name, 'value' => $lsa->id]);

        $l_ca = Ledger::create(['ledger_name' => LedgerHelper::$CASH_AC,
            'ledger_group_id' => $lg_ca->id, 'is_default' => true]);
        GroupMap::create(['key' => $l_ca->ledger_name, 'value' => $l_ca->id]);


        $lg_ba = LedgerGroup::create(['group_name' => LedgerHelper::$BANK_ACCOUNTS,
            'parent' => $lg_ca->id,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_ba->group_name, 'value' => $lg_ba->id]);

        $lg_sih = LedgerGroup::create(['group_name' => LedgerHelper::$STOCK_IN_HAND,
            'parent' => $lg_ca->id,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_sih->group_name, 'value' => $lg_sih->id]);

        $lg_fa = LedgerGroup::create(['group_name' => LedgerHelper::$FixedAsset,
            'parent' => -1,
            'nature' => Nature::$ASSET,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_fa->group_name, 'value' => $lg_fa->id]);


        /* Liabilities */


        $lg_cpa = LedgerGroup::create(['group_name' => LedgerHelper::$CAPITAL_ACCOUNTS,
            'parent' => -1,
            'nature' => Nature::$LIABILITIES,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_cpa->group_name, 'value' => $lg_cpa->id]);

        $lg_lal = LedgerGroup::create(['group_name' => LedgerHelper::$LOAN_AND_LIABILITIES,
            'parent' => -1,
            'nature' => Nature::$LIABILITIES,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_lal->group_name, 'value' => $lg_lal->id]);

        $lg_cl = LedgerGroup::create(['group_name' => LedgerHelper::$CURRENT_LIABILITIES,
            'parent' => -1,
            'nature' => Nature::$LIABILITIES,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_cl->group_name, 'value' => $lg_cl->id]);


        $lpa = Ledger::create(['ledger_name' => LedgerHelper::$ACCOUNTS_PAYABLE, 'ledger_group_id' => $lg_cl->id, 'is_default' => true]);
        GroupMap::create(['key' => $lpa->ledger_name, 'value' => $lpa->id]);

        $lpa = Ledger::create(['ledger_name' => LedgerHelper::$TAX_PAYABLE, 'ledger_group_id' => $lg_cl->id, 'is_default' => true]);
        GroupMap::create(['key' => $lpa->ledger_name, 'value' => $lpa->id]);

        $lg_dt = LedgerGroup::create(['group_name' => LedgerHelper::$DUTIES_AND_TAXES,
            'parent' => $lg_cl->id,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_dt->group_name, 'value' => $lg_dt->id]);


        /* Income */

        $lg_di = LedgerGroup::create(['group_name' => LedgerHelper::$DIRECT_INCOME,
            'parent' => -1,
            'nature' => Nature::$Income,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_di->group_name, 'value' => $lg_di->id]);

        $lpa = Ledger::create(['ledger_name' => LedgerHelper::$SERVICE_REVENUE_AC, 'ledger_group_id' => $lg_di->id, 'is_default' => true]);
        GroupMap::create(['key' => $lpa->ledger_name, 'value' => $lpa->id]);


        $lpa = Ledger::create(['ledger_name' => LedgerHelper::$OTHER_CHARGES, 'ledger_group_id' => $lg_di->id, 'is_default' => true]);
        GroupMap::create(['key' => $lpa->ledger_name, 'value' => $lpa->id]);


        $lg_ii = LedgerGroup::create(['group_name' => LedgerHelper::$INDIRECT_INCOME,
            'parent' => -1,
            'nature' => Nature::$Income,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_ii->group_name, 'value' => $lg_ii->id]);

        $lg_sa = LedgerGroup::create(['group_name' => LedgerHelper::$SALES_ACCOUNT,
            'parent' => -1,
            'nature' => Nature::$Income,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_sa->group_name, 'value' => $lg_sa->id]);

        $lsa = Ledger::create(['ledger_name' => LedgerHelper::$SALES_AC, 'ledger_group_id' => $lg_sa->id, 'is_default' => true]);
        GroupMap::create(['key' => $lsa->ledger_name, 'value' => $lsa->id]);

        $lg_de = LedgerGroup::create(['group_name' => LedgerHelper::$DIRECT_EXPENSE,
            'parent' => -1,
            'nature' => Nature::$EXPENSE,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_de->group_name, 'value' => $lg_de->id]);

        $lg_ie = LedgerGroup::create(['group_name' => LedgerHelper::$INDIRECT_EXPENSE,
            'parent' => -1,
            'nature' => Nature::$EXPENSE,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_ie->group_name, 'value' => $lg_ie->id]);

        $lg_pa = LedgerGroup::create(['group_name' => LedgerHelper::$PURCHASE_ACCOUNT,
            'parent' => -1,
            'nature' => Nature::$EXPENSE,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);

        GroupMap::create(['key' => $lg_pa->group_name, 'value' => $lg_pa->id]);

        $lpa = Ledger::create(['ledger_name' => LedgerHelper::$PURCHASE_AC, 'ledger_group_id' => $lg_pa->id, 'is_default' => true]);
        GroupMap::create(['key' => $lpa->ledger_name, 'value' => $lpa->id]);

        $lpa = Ledger::create(['ledger_name' => LedgerHelper::$COST_OF_GOODS_SOLD, 'ledger_group_id' => $lg_pa->id, 'is_default' => true]);
        GroupMap::create(['key' => $lpa->ledger_name, 'value' => $lpa->id]);


        /* Salary Account */
        $lg_pa = LedgerGroup::create(['group_name' => LedgerHelper::$SALARY_ACCOUNT,
            'parent' => -1,
            'nature' => Nature::$EXPENSE,
            'cashflow_type' => CashFlowType::$FINANCIAL,
            'is_default' => true]);
        GroupMap::create(['key' => $lg_pa->group_name, 'value' => $lg_pa->id]);

        $lpa = Ledger::create(['ledger_name' => LedgerHelper::$SALARY_AC, 'ledger_group_id' => $lg_pa->id, 'is_default' => true]);
        GroupMap::create(['key' => $lpa->ledger_name, 'value' => $lpa->id]);


    }
}

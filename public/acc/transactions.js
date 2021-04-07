var ractive = new Ractive({
    target: '#target',
    template: '#template',
    data: {
        txns: transactions,
        ledgers: ledgers,
        tcr: 0,
        tdr: 0
    },
    delete(index) {

        let txns = ractive.get('txns');
        console.log(txns, txns.length)
        if (txns.length > 2) {
            ractive.splice('txns', index, 1)
        }
    },
    addNewTransaction() {
        ractive.push('txns', {
            "entry_type": "Dr",
            "note": ""

        })
        let txns = ractive.get('txns')

        // alert(txns.length)
        let length = txns.length
        for (let i = 0; i < length; i++) {
            $(`#ledger${i}`).selectize({
                placeholder: '--Select Ledger--',
            });
            $(`#ledger${i}`).on('change', function (e, v) {
                let index = parseInt($(this).attr('index'))
                let ledger_id = parseInt($(this).find('option:selected').val())
                let txn = ractive.get('txns')[i];
                ractive.set(`txns.${index}.ledger_id`, ledger_id)
                if (bankLedgerId.includes(ledger_id)) {
                    ractive.set(`txns.${index}.is_bank`, true)
                } else {
                    ractive.set(`txns.${index}.is_bank`, false)
                }
            });
        }



        // registerListener()
    },
    onLedgerChange(i, ledger_id) {
        alert('changed')
    },
    observe: {
        show(value) {
            console.log(`show changed to '${value}'`)
        },
        'txns': {
            handler(value, old, path, idx) {
                console.log(`${path} changed to '${value}'`)
            },
            init: true,
            strict: true
        }
    },
    oninit() {

        // alert('oninit')
    },
    onrender() {
        // alert('render called')
    },

    test() {
        alert('boom')
    }
});

for (let i = 0; i < 2; i++) {
    // $(`#ledger${txns.length}`).selectize();
    $(`#ledger${i}`).selectize({
        placeholder: '--Select Ledger--',
    });
    $(`#ledger${i}`).on('change', function (e, v) {
        let index = parseInt($(this).attr('index'))
        let ledger_id = parseInt($(this).find('option:selected').val())
        let txn = ractive.get('txns')[i];
        ractive.set(`txns.${index}.ledger_id`, ledger_id)
        if (bankLedgerId.includes(ledger_id)) {
            ractive.set(`txns.${index}.is_bank`, true)
        } else {
            ractive.set(`txns.${index}.is_bank`, false)
        }
    });

}


ractive.observe({
    'txns': function (e) {
        console.log(e)
        calculateTotalDrCr();
    }
})


function calculateTotalDrCr() {
    let txns = ractive.get('txns');
    let cr = 0;
    let dr = 0;
    for (let txn of txns) {
        if (txn.entry_type === 'Cr') {
            cr += parseInt(txn.amount || '0')
        } else {
            dr += parseInt(txn.amount || '0')
        }

        console.log(cr, dr, txn.amount)
    }
    ractive.set('tcr', cr)
    ractive.set('tdr', dr)
    return {dr, cr}
}









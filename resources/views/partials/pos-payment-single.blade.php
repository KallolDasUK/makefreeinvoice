<div class="modal fade" id="posPaymentSingleModal" tabindex="-1" role="dialog"
     aria-labelledby="posPaymentSingleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document" style="margin-top:10px!important;" is_update="0">
        <div class="modal-content">

            <div class="modal-body" id="posPaymentSingleModalContent">


                <div id="singlePayment">

                </div>


            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>


@verbatim
    <script id="singlePaymentTemplate" type="text/ractive">
                        <h4>{{ order.pos_number }}</h4>
                                        <div class="row">
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-body"><!----><!---->
                                                        <div class="list-group">
                                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                                Total Item
                                                                <span class="badge badge-primary badge-pill">{{ pos_items.length }}</span></div>
                                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                                Sub Total
                                                                <span class="font-weight-bold">{{ currency }}{{ sub_total }}</span>
                                                            </div>


                                                            {{ #each charges }}
        <div
            class="list-group-item  justify-content-between align-items-center {{ amount==0?'d-none':'d-flex' }}">
                                                                {{ key }}

        <span class="{{ amount<0?'text-danger':'' }}
        font-weight-bold ">{{ currency }}{{ amount==0?'':amount }} {{ percentage?`(${value.replace('-','')})`:'' }}</span>
                                                            </div>

                                                            {{ /each }}


        <div class="list-group-item d-flex justify-content-between align-items-center">
            Total
            <span
                class="font-weight-bold"><span>{{ currency }}{{ total }}</span></span>
                                                            </div>
                                                            <div class="list-group-item d-flex justify-content-between align-items-center">

                                                               Paid
                                                               <span class="font-weight-bold">{{ order.payment }}</span></div>
                                                                <div class="list-group-item d-flex justify-content-between align-items-center">
           Total Payable
           <span
               class="font-weight-bold"><h2>{{ currency }}{{ due }}</h2></span>
                                                            </div>
                                                        </div>
                                                    </div><!----><!----></div>

{{ #each charges:i }}
        <div class="row align-items-center justify-content-center mt-4">


            <div class="col">
                <div class="font-weight-bold"><input type="text" class="form-control form-control-sm"
                                                     placeholder="Ex. Vat" value="{{ key }}"></div>
                </div>
                <div>
                <span class="{{ i>1?'':'d-none' }}">
                <i class="fa fa-trash text-danger" on-click="@this.onChargeDelete(i)"></i></span>
</div>
                <div class="col">
                <input type="text" class="form-control form-control-sm" value="{{ value }}"
                                        placeholder="ex. 5%,100,-5,-10%">

                                         </div>

            </div>{{/each}}

        <button type="button" class="btn btn-outline-primary btn-sm mt-4" style="width: 100%;margin-bottom: 100px" on-click="@this.onChargeCreate()">+ Add More Field
       </button>
                                           </div>
                                           <div class="col">

                                               <div class="row align-items-center">
                                                   <div class="col ">

                                                       <div class="card " style="border: none">
                                                           <div class="d-flex align-items-center justify-content-center">
                                                               <div class="card-body ">
                                                                   <h2>GIVEN</h2>
                                                                   <h3>{{ given }}</h3>
                                                                </div>
                                                                <div class="vertical-divider"></div>
                                                            </div>

                                                        </div>


                                                    </div>
                                                    <div class="col ">

                                                        <div class="card " style="border: none">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <div class="card-body ">
                                                                    <h3>{{ change<0?'DUE':'CHANGE' }}</h3>
                                                                    <h3>{{ Math.abs(change) }}</h3>
                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>


                                                </div>
                                                <label for="payment_method">Payment Method</label>
                                                {{ #each payments:i }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <select
                        id="payment_ledger_id{{i}}" index="{{i}}" class="form-control"
                                                                name="ledger_id" value="{{ ledger_id }}">
                                                                {{ #each ledgers:i }}
        <option
            value="{{ id }}">
                                                                    {{ ledger_name }}
        </option>
{{ /each }}
        </select>
    </div> <!-- Form Group-->
</div> <!-- Col-->
<span class="{{ i>=1?'':'d-none' }}">
                                        <i class="fa fa-trash text-danger" on-click="@this.onPaymentRowDelete(i)"></i></span>
                                                    <div class="col">
                                                        <input type="text" placeholder="amount" class="form-control amount"
                                                               value="{{ amount }}">
                                                    </div><!-- Col-->
                                                </div><!-- Row-->
                                                {{ /each }}
        <button type="button" class="btn btn-outline-primary btn-sm mt-4"
                style="width: 100%;margin-bottom: 100px" on-click="@this.onPaymentRowCreate()">+ Add
            More Method
        </button>
        <div class="row align-items-center justify-content-between">
        <div class="col"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
        <div class="col"><button type="button" class="btn btn-primary btn-lg" id="singlePaymentBtn"
                        style="position:relative;min-width: 200px">
                    <code style="position:absolute;right: 0;top: -30px"> Ctrl + Enter</code>
                    <span class="spinner-grow spinner-grow-sm spinner d-none" role="status"
                          aria-hidden="true"></span>
                    Pay Now
                </button></div>
</div>


    </div>

</div>

    </script>
@endverbatim

<div class="modal fade" id="subscriptionPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">
        <form id="subscriptionPaymentForm" method="post" action="" index="">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                       <div class="">
                           <div class="p-4">
                               <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                   <h4 class="mb-10 font-weight-bold text-dark">Enter your Payment Details</h4>
                                   <div class="row">
                                       <div class="col-xl-6">
                                           <!--begin::Input-->
                                           <div class="form-group fv-plugins-icon-container">
                                               <label>Name on Card</label>
                                               <input type="text" class="form-control  input-sm form-control-solid form-control-lg" name="ccname" placeholder="Card Name" value="John Wick">
                                           </div>
                                           <!--end::Input-->
                                       </div>
                                       <div class="col-xl-6">
                                           <!--begin::Input-->
                                           <div class="form-group fv-plugins-icon-container">
                                               <label>Card Number</label>
                                               <input type="text" class="form-control  input-sm form-control-solid form-control-lg" name="ccnumber" placeholder="Card Number" value="4444 3333 2222 1111">
                                           </div>
                                           <!--end::Input-->
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="col-xl-4">
                                           <!--begin::Input-->
                                           <div class="form-group fv-plugins-icon-container">
                                               <label>Expiry Month</label>
                                               <input type="number" class="form-control  input-sm form-control-solid form-control-lg" name="ccmonth" placeholder="Card Expiry Month" value="01">
                                           </div>
                                           <!--end::Input-->
                                       </div>
                                       <div class="col-xl-4">
                                           <!--begin::Input-->
                                           <div class="form-group fv-plugins-icon-container">
                                               <label>Expiry Year</label>
                                               <input type="number" class="form-control  input-sm form-control-solid form-control-lg" name="ccyear" placeholder="Card Expire Year" value="21">
                                           </div>
                                           <!--end::Input-->
                                       </div>
                                       <div class="col-xl-4">
                                           <!--begin::Input-->
                                           <div class="form-group fv-plugins-icon-container">
                                               <label>CVV Number</label>
                                               <input type="text" class="form-control input-sm form-control-solid form-control-lg" name="cccvv" placeholder="Card CVV Number" value="123">
                                           </div>
                                           <!--end::Input-->
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storeTax">
                        <span class="spinner-grow spinner-grow-sm spinner d-none" role="status" aria-hidden="true"></span>
                        Confirm Payment
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>



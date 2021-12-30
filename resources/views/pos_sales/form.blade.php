<div id="pos"></div>
<div class="hidden">
    <input type="text" name="pos_items" id="pos_items" hidden>
    <input type="text" name="charges" id="charges" hidden>
    <input type="text" name="sub_total" id="sub_total" hidden>
    <input type="text" name="total" id="total" hidden>
    <input type="text" name="payments" id="payments" hidden>
</div>

@verbatim
    <script id="posTemplate" type="text/ractive">
<div class="modal fade" id="posPaymentModal" role="dialog" aria-labelledby="posPaymentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document" style="margin-top:10px!important;" is_update="0">
          <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                    <div class="col">

                    <div class="card"><!----><!----><div class="card-body"><!----><!----><div class="list-group"><div class="list-group-item d-flex justify-content-between align-items-center">
                      Total Item
                      <span class="badge badge-primary badge-pill">{{ pos_items.length }}</span></div> <div class="list-group-item d-flex justify-content-between align-items-center">
                        Sub Total
                      <span class="font-weight-bold">{{ currency }}{{ sub_total.toFixed(2) }}</span></div>
                       <div class="list-group-item d-flex justify-content-between align-items-center">

                       Tax
                      <span class="font-weight-bold">$ 0.00 (0 %)</span></div>

                      {{ #each charges }}
        <div class="list-group-item  justify-content-between align-items-center {{ amount==0?'d-none':'d-flex' }}">
        {{ key }}

        <span class="{{ amount<0?'text-danger':'' }}
        font-weight-bold ">{{ currency }}{{ amount==0?'':amount }} {{ percentage?`(${value.replace('-','')})`:'' }}</span></div>

        {{ /each }}
        <div class="list-group-item d-flex justify-content-between align-items-center">
                               Total
                              <span class="font-weight-bold"><h2>{{ currency }}{{ total.toFixed(2) }}</h2></span></div></div></div><!----><!----></div>


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
                     id="ledger_id{{i}}" index="{{i}}"   class="form-control"
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
    <input type="text" placeholder="amount" class="form-control amount" value="{{ amount }}">
    </div><!-- Col-->
</div><!-- Row-->
{{ /each }}
        <button type="button" class="btn btn-primary btn-sm mt-4" style="width: 100%;margin-bottom: 100px" on-click="@this.onPaymentRowCreate()">+ Add More Method
              </button>
              </div>

      </div>
      </div>
      <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-lg" id="storePosPaymentBtn" style="position:relative;min-width: 200px">
                           <code style="position:absolute;right: 0;top: -30px"> Ctrl + Enter</code>
                        <span class="spinner-grow spinner-grow-sm spinner d-none" role="status"
                              aria-hidden="true"></span>
                        Pay Now
                    </button>
                </div>
      </div>

      </div>
      </div>

      <div class="row">
      <div class="col-7 ">
      <div class="row">
      <div class="col">
      <div class="item-search " style="position:relative;">
      <input name="product_search" id="product_search" type="text" placeholder="Scan/Search Items"
      class="form-control" style="padding-left: 50px">
      <i class="fa fa-barcode" style="font-size: 35px;position:absolute; right: 7px;top: 0px"></i>
      <i class="fa fa-search"
      style="font-size: 20px;position:absolute; left: 16px;top: 10px;color: gray!important;"></i>
      </div>
      </div>
      <div class="col">
      <div class="d-flex">
      <select name="customer_id" id="customer_id" class="form-control form-control-lg input-lg"
      style="font-size: 18px;padding-left: 50px">
{{#each customers:i}}
        <option value="{{ id }}" {{ name == 'Walk In Customer'?'selected':'' }}>{{ name }} {{ phone }}</option>
                            {{ /each }}
        </select>
        <button type="button" class="btn" style="color: #065a92" data-toggle="modal" data-target="#customerModal"><i class="fa fa-user-plus"></i></button>
    </div>

</div>
</div>


<div class=" {{ tab === 'orders'? 'd-none':'d-flex' }} category_items mt-4" style="max-height: 120px;overflow-y: scroll">
<div class="ml-2 category_item d-flex align-items-center justify-content-center rounded btn btn-primary" data-toggle="modal" data-target="#categoryModal">
    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="40px"
         height="40px">
        <path
            d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"/>
    </svg>


</div>
 {{#each categories:i}}
        <div class="ml-2 category_item d-flex align-items-center justify-content-center rounded"  on-click="@this.onCategorySelected(id)">
            <span class="">{{ name }}</span>
    </div>
{{ /each }}

        </div>
        <div class=" items mt-4 {{ tab === 'products'? 'd-flex':'d-none' }}" style="min-height: 400px;max-height: 400px;overflow-y: scroll">
            <div class="ml-2 item d-flex align-items-center justify-content-center rounded btn btn-primary" data-toggle="modal" data-target="#productModal">

                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50px"
                     height="50px">
                    <path
                        d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"/>
                </svg>
            </div>

           {{#each products:i}}
        <span class="product" style="position:relative;" >
        <i class="{{ is_bookmarked == '0'?'far fa-bookmark':'fas fa-bookmark' }}
        bookmark_icon"  data-toggle="tooltip" data-placement="top"
         title="{{ is_bookmarked == '0'?'Click To Bookmark':'Remove Bookmark' }}"
          product-id="{{id}}" style="position: absolute;right: 0;z-index: 20;display: none"></i>

        <div class="ml-2 item rounded btn" on-click="@this.onProductSelected(id)" style=" {{^ hide_image }}
        background-image: url('{{ image }}'); {{/ hide_image }}" >
        {{^ hide_name }}
        <span class="" style="text-shadow: 1px 1px 0 white,-1px -1px 0 white;">{{ short_name }}</span>
        {{/ hide_name }}


        {{^ hide_stock }}
        <span class="{{ stock > 0 ?'':'text-danger' }}"
              style="position:absolute;left: 5px;bottom: 5px"><small>{{ stock }}</small></span>
{{/ hide_stock }}

        {{^ hide_price }}
        {{# show_sale_price }}
        <span style="position:absolute;right: 5px;bottom: 5px;font-weight: normal">{{ currency }}{{ sell_price.replace('.00','') }}</span>
         {{/ show_sale_price }}
        {{# show_purchase_price }}
        <span style="position:absolute;right: 5px;bottom: 5px;font-weight: normal">{{ currency }}{{ purchase_price.replace('.00','') }}</span>
         {{/ show_purchase_price }}

        {{/ hide_price }}

        </div>
        </span>
{{ /each }}
        {{#each empty_boxes:i}}
        <div class="ml-2 item rounded btn">
             <span class=""></span>
                 <span
              style="position:absolute;left: 5px;bottom: 5px"><small></small></span>
        <span style="position:absolute;right: 5px;bottom: 5px;font-weight: normal"></span>
    </div>
{{ /each }}


        </div>
        <div class=" items mt-4 {{ tab === 'bookmarks'?'d-flex':'d-none' }}" style="min-height: 400px;max-height: 400px;overflow-y: scroll">
               {{#each bookmarks:i}}
        <span class="product" style="position:relative;">
        <i class="fas fa-bookmark bookmark_icon"  data-toggle="tooltip" data-placement="top" title="Remove Bookmark"  product-id="{{id}}" style="position: absolute;right: 0;z-index: 20;display: none"></i>

        <div class="ml-2 item rounded btn" on-click="@this.onProductSelected(id)" style=" {{^ hide_image }}
        background-image: url('{{ image }}'); {{/ hide_image }}"  >
              {{^ hide_name }}
        <span class="">{{ short_name }}</span>
        {{/ hide_name }}

        {{^ hide_stock }}
        <span class="{{ stock > 0 ?'':'text-danger' }}"
              style="position:absolute;left: 5px;bottom: 5px"><small>{{ stock }}</small></span>
{{/ hide_stock }}

        {{^ hide_price }}
        {{# show_sale_price }}
        <span style="position:absolute;right: 5px;bottom: 5px;font-weight: normal">{{ currency }}{{ sell_price.replace('.00','') }}</span>
         {{/ show_sale_price }}
        {{# show_purchase_price }}
        <span style="position:absolute;right: 5px;bottom: 5px;font-weight: normal">{{ currency }}{{ purchase_price.replace('.00','') }}</span>
         {{/ show_purchase_price }}

        {{/ hide_price }}
        </div>
        </span>
{{ /each }}

        {{#each bookmark_empty_boxes:i}}
        <div class="ml-2 item rounded btn">
             <span class=""></span>
                 <span
              style="position:absolute;left: 5px;bottom: 5px"><small></small></span>
        <span style="position:absolute;right: 5px;bottom: 5px;font-weight: normal"></span>
    </div>
{{ /each }}
        </div>
        <div class="{{ tab === 'custom_fields'?'':'d-none' }} mt-4" style="min-height: 400px;max-height: 400px;overflow-y: scroll">
            <h3>Quick Tap</h3>
        </div>
        <div class="{{ tab === 'orders'?'':'d-none' }} mt-4" style="min-height: 550px;max-height: 550px;overflow-y: scroll;overflow-x: hidden">

        <div class="row align-items-center justify-content-center">

                                    <input type="text" class="form-control" style="width:160px;margin-left: 10px;" placeholder="Pos Number" id="pos_number" name="pos_number" value="{{ pos_number }}">

                                    <div class="input-daterange input-group col" >
                                        <input type="date" class="form-control " name="start_date"  id="start_date"  value="{{ start_date }}" placeholder="Start">
                                        <div class="input-group-append">
									<span class="input-group-text">
										...
                                    </span>
                                        </div>
                                        <input type="date" class="form-control" name="end_date" id="end_date" value="{{ end_date }}" placeholder="End">
                                    </div>


                                <div class="col">
                                    <button role="button" type="button" on-click="@this.onOrderFilter()" class="btn btn-primary px-6 mx-2  font-weight-bold">
                                        <i class="fas fa-sliders-h"></i>
                                        Filter
                                    </button>
                                    <span style="font-size: 20px" class="ml-4">{{ orders.length }} Sales</span>
                                </div>


                            </div>
            {{#each orders:i}}
        <div class="card mt-2" index="{{id}}" >
           <div class="m-2">
           <div class="row align-items-center justify-content-between">
           <div class="col " style="margin-left: 20px">
           <h1>{{ currency }}{{ total }}</h1>
                        <p>{{ pos_number }}</p>

                        <span>{{ date||'n/a' }}</span>

                        </div>
                        <div class="col">
                        <h4>
                        <div class="{{ payment>=total?'':'d-none' }}"><span class="badge badge-light"> <i class="fa fa-check-circle text-success"></i> Paid</span></div>
                       <div class="{{ payment>=total?'d-none':'' }}">
                        <span class="{{ payment>0?'d-block':'d-none' }}">
                        PAID  {{ currency }}{{ payment }}
        </span>
        <span class="{{ due>0?'d-block':'d-none' }}">
                        DUE  {{ currency }}{{ due.replace('.00','') }}
        </span>
         <button type="button" on-click="@this.onOrderPay(id)"   class="btn btn-primary btn-sm " style="min-width: 100px;height: 100%">

        Get Payment</button>

</div>
</h4>
{{ customer.name }}
        {{ customer.phone }}
        </div>
                <div class="col-6">
                <div>



                  <button type="button" on-click="@this.onOrderDelete(id)"   class="btn btn-outline-danger btn-sm " {{ can_delete }} style="min-width: 100px;">
         <i class="fa fa-edit"></i>
         DELETE</button>
        <button class="btn btn-secondary btn-sm mx-2" on-click="@this.onOrderView(id)"  type="button">
        <i class="fa fa-eye"></i>
        View Items</button>

        <button type="button" on-click="@this.onOrderPrint(id)"   class="btn btn-outline-secondary btn-lg " style="min-width: 100px;height: 100%">
        <i class="fa fa-print"></i>
        PRINT</button></div>
        <div>

</div>









        </div>

</div>

 </div>
</div>


{{/each}}
        {{^orders}}
        <div class="d-flex align-items-center justify-content-center">
         <h1 >No orders</h1>
        </div>

{{/orders}}

        </div>
    </div>


    <div class="col-5">
        <div style="height: 40px">
            <div class="row align-items-center justify-content-between">
                <a href="/app" class="col-4 mx-1 btn btn-outline-primary text-center btn-sm">
                    <i class="fa fa-home"></i>
                    HOME
                </a>
<!--                <button type="button" class="col mx-1 btn btn-outline-primary btn-sm">-->
<!--                    <i class="fa fa-cog"></i>-->
<!--                    POS Settings-->
<!--                </button>-->
               <div>
               <i class="fa fa-expand"></i>
                    <code style="font-size: 20px">F11</code> <small>(full screen)</small>
</div>

                <a target="_blank"  href="../accounting/settings/pos" class="col-4 mx-1 btn btn-outline-primary btn-sm ">
                <i class="fa fa-cog"></i>
                    POS Settings
                </a>
            </div>
        </div>
        <div class="cart">
            <div style="overflow-y: scroll;height: 50vh">
                <table class="table bg-white table-head-custom table-vertical-center text-center">
                    <tr>
                        <th style="text-align: start">ITEM</th>
                        <th>PRICE</th>
                        <th>QNT</th>
                        <th>UNIT</th>
                        <th>AMOUNT</th>
                    </tr>

                    <tbody>
                   {{ #each pos_items:i }}
        <tr id="line{{i}}">
   <td style="text-align: start;max-width: 130px">
        {{  product.name }}
        <br>
        <small></small>
    </td>
    <td style="text-align: center">
        <input style="max-width: 90px" type="text"
               class="form-control form-control-sm text-center"
               value="{{ price }}">
        </td>
        <td>
            <div class="d-flex">
                <button type="button" class="btn btn-sm btn-outline-danger {{ qnt <=1?'':'d-none' }}" style="font-weight: bolder;" on-click="@this.delete_pos_item(i)">
                    <span class="fa fa-trash-alt"></span>
                </button>
                <button type="button" class="btn btn-sm btn-danger {{ qnt > 1?'':'d-none' }}" style="font-weight: bolder;" on-click="@this.decrement(i)">-</button>
                <input style="min-width: 80px;max-width: 80px" type="number" step="any"
                       class="form-control form-control-sm text-center mx-2"
                       value="{{ qnt }}"
                        {{# prevent_sale_on_stock_out }}
        max="{{ product.stock }}"
                        {{/ prevent_sale_on_stock_out }}

        >
 <button type="button" class="btn btn-sm btn-primary" style="font-weight: bolder;" on-click="@this.increment(i)">
     +
 </button>
</div>
</td>
<td><input type="text" value="{{ unit }}"
                   style="max-width: 30px;outline: none; border: 0px !important; text-align: end; text-decoration: underline dashed red;">
        </td>
        <td>{{  qnt * price  }}</td>
    </tr>
                    {{ /each }}

        </tbody>
    </table>
    <div class="empty-cart bg-white text-center {{ pos_items.length == 0?'':'d-none' }} align-items-center justify-content-center rounded"
         style="height: 300px;">
        <div>
            <img width="100" height="100"
                 src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_UGVlPqcYGJxa04bB_ZnDWZpja9qvT3ywew&usqp=CAU"
                 class="mt-4">
            <h2>Empty Cart</h2>
            <p>Search Item or Scan Barcode to add item to cart</p>
        </div>

    </div>
</div>
<div class="action_buttons row mr-4" style="position: fixed;right: 0;bottom: 0;margin-bottom: 20px;width: 40%;z-index: 222">
    <button id="suspend" onClick="window.location.reload();" type="button" class="col btn btn-danger btn-lg" style="font-size: 17px;"> Suspend</button>
    <button id="credit_sale" type="button"  class="col btn btn-lg btn-info mx-4 credit_sale" style="font-size: 17px;position:relative;">
                              <code style="position:absolute;right: 0;top: -30px"> Alt + Enter</code>
                          <span class="spinner-grow spinner-grow-sm spinner d-none" role="status" aria-hidden="true"></span>
 Credit Sale</button>
    <button id="payment" type="button" data-toggle="modal" data-target="#posPaymentModal"  class="col btn btn-primary btn-lg" style="font-size: 17px;position:relative;">
                             <code style="position:absolute;right: 0;top: -30px"> Ctrl + Enter</code>
                             <span class="spinner-grow spinner-grow-sm spinner d-none" role="status" aria-hidden="true"></span>
Payment</button>
</div>

<div class="action_buttons row bg-white" style="position: fixed;left: 30px;bottom: 0;margin-bottom: 20px;width: 50%;z-index: 222">
    <button type="button" class="col btn  {{ tab === 'products'? 'btn-primary':'btn-outline-primary' }} btn-lg" style="font-size: 17px;" on-click="@this.onTabChange('products')">All Items</button>
    <button  type="button" class="col btn {{ tab === 'bookmarks'? 'btn-primary':'btn-outline-primary' }} btn-lg  mx-4" style="font-size: 17px;" on-click="@this.onTabChange('bookmarks')">Bookmarked</button>
    <button  type="button" class="d-none col btn  {{ tab === 'custom_fields'? 'btn-primary':'btn-outline-primary' }} btn-lg mr-4" style="font-size: 17px;" on-click="@this.onTabChange('custom_fields')">QuickTap</button>
    <button  type="button" class="col btn  {{ tab === 'orders'? 'btn-primary':'btn-outline-primary' }} btn-lg" style="font-size: 17px;" on-click="@this.onTabChange('orders')">Sales</button>
</div>
<div class="cart-details">
    <div class="row">
        <div class="col"> {{ #each charges:i }}
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
                                        placeholder="ex. 5% or 100">

                                         </div>

            </div>{{/each}}

        <button type="button" class="btn btn-primary btn-sm mt-4" style="width: 100%;margin-bottom: 100px" on-click="@this.onChargeCreate()">+ Add More Field
        </button>
    </div>
    <div class="col">
        <div class="card">
            <div class="p-2">
                <div class="row align-items-center justify-content-center">
                    <div class="col">
                        <b>Sub Total</b>
                    </div>
                    <div class="col text-right">
{{ currency }}  {{ sub_total }}
        </div>
    </div>
    {{ #each charges }}
        <div class="row align-items-center justify-content-center {{ amount<0 ?'text-danger':'' }}">
        <div class="col">
            {{ key }}
        </div>
        <div class="col text-right">
            {{ amount==0?'':amount }} {{ percentage?`(${value.replace('-','')})`:'' }}
        </div>
    </div>
    {{ /each }}

        <div class="row">
            <div class="col">
                <h3>TOTAL</h3>
            </div>
            <div class="col text-right">
                <h2> {{ currency }} {{ total }}</h2>
        </div>

    </div> <div class="note">
        <textarea class="form-control" name="note" id="note" cols="20" rows="2" placeholder="Notes"></textarea>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
















































    </script>
@endverbatim


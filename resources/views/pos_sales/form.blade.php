<div id="pos"></div>

@verbatim
    <script id="posTemplate" type="text/ractive">

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
        <button type="button" class="btn" style="color: #065a92"><i class="fa fa-user-plus"></i></button>
    </div>

</div>
</div>


<div class="d-flex category_items mt-4">
<div class="ml-2 category_item d-flex align-items-center justify-content-center rounded btn btn-info">
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
            <div class="ml-2 item d-flex align-items-center justify-content-center rounded btn btn-primary">

                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50px"
                     height="50px">
                    <path
                        d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"/>
                </svg>
            </div>

           {{#each products:i}}
        <div class="ml-2 item rounded btn" on-click="@this.onProductSelected(id)">
             <span class="">{{ name }}</span>
                 <span class="{{ stock > 0 ?'':'text-danger' }}"
              style="position:absolute;left: 5px;bottom: 5px"><small>{{ stock }} {{ sell_unit }}</small></span>
        <span style="position:absolute;right: 5px;bottom: 5px;font-weight: normal">{{ sell_price }}</span>
    </div>
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
            <h3>Bookmark Tab</h3>
        </div>
        <div class="{{ tab === 'custom_fields'?'d-flex':'d-none' }} items mt-4" style="min-height: 400px;max-height: 400px;overflow-y: scroll">
            <h3>Quick Tap</h3>
        </div>
        <div class="{{ tab === 'orders'?'d-flex':'d-none' }} items mt-4" style="min-height: 400px;max-height: 400px;overflow-y: scroll">
            <h3>All Orders Here</h3>
        </div>
    </div>


    <div class="col-5">
        <div style="height: 40px">
            <div class="row align-items-center justify-content-center">
                <a href="/app" class="col-2 mx-1 btn btn-outline-primary text-center btn-sm">
                    <i class="fa fa-home"></i>
                    HOME
                </a>
                <button type="button" class="col mx-1 btn btn-outline-primary btn-sm">
                    <i class="fa fa-cog"></i>
                    POS Settings
                </button>
                <button type="button" class="col mx-1 btn btn-outline-primary text-center btn-sm">
                    <i class="fa fa-cog"></i>
                    <small>Receipt Settings</small>
                </button>

                <button type="button" class="col mx-1 btn btn-outline-info btn-sm">
                    <i class="fa fa-file-audio"></i>
                    Upgrade
                </button>
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
   <td style="text-align: start;max-width: 130px"><i class="fa fa-edit"
                                                     style="color: gray"></i> {{  product.name }}
        <br>
        <small></small>
    </td>
    <td style="text-align: center">
        <input style="max-width: 50px" type="text"
               class="form-control form-control-sm text-center"
               value="{{ price }}">
        </td>
        <td>
            <div class="d-flex">
                <button type="button" class="btn btn-sm btn-outline-danger {{ qnt <=1?'':'d-none' }}" style="font-weight: bolder;" on-click="@this.delete_pos_item(i)">
                    <span class="fa fa-trash-alt"></span>
                </button>
                <button type="button" class="btn btn-sm btn-danger {{ qnt > 1?'':'d-none' }}" style="font-weight: bolder;" on-click="@this.decrement(i)">-</button>
                <input style="max-width: 50px" type="text"
                       class="form-control form-control-sm text-center mx-2"
                       value="{{ qnt }}">
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
    <button type="button" class="col btn btn-danger btn-lg" style="font-size: 17px;">Suspend</button>
    <button type="button"  class="col btn btn-lg btn-info mx-4" style="font-size: 17px;">Credit Sale</button>
    <button type="button"  class="col btn btn-primary btn-lg" style="font-size: 17px;">Payment</button>
</div>

<div class="action_buttons row bg-white" style="position: fixed;left: 30px;bottom: 0;margin-bottom: 20px;width: 50%;z-index: 222">
    <button type="button" class="col btn  {{ tab === 'products'? 'btn-primary':'btn-outline-primary' }} btn-lg" style="font-size: 17px;" on-click="@this.onTabChange('products')">All Items</button>
    <button  type="button" class="col btn {{ tab === 'bookmarks'? 'btn-primary':'btn-outline-primary' }} btn-lg  mx-4" style="font-size: 17px;" on-click="@this.onTabChange('bookmarks')">Bookmarked</button>
    <button  type="button" class="col btn  {{ tab === 'custom_fields'? 'btn-primary':'btn-outline-primary' }} btn-lg mr-4" style="font-size: 17px;" on-click="@this.onTabChange('custom_fields')">QuickTap</button>
    <button  type="button" class="col btn  {{ tab === 'orders'? 'btn-primary':'btn-outline-primary' }} btn-lg" style="font-size: 17px;" on-click="@this.onTabChange('orders')">Orders</button>
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

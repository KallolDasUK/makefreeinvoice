<li class="col-3">
    <input type="checkbox" {{ $global_settings->premium_pos_sales_viewAny??false?'checked':''}}/>
    <label>Pos Sales</label>
    <ul class="manu d-none">
        <li>
            <input type="checkbox"
                   name="pos_sales.viewAny" {{ $global_settings->premium_pos_sales_viewAny??false?'checked':''}}/>
            <label>Show List</label>
        </li>
        <li>
            <input type="checkbox"
                   name="pos_sales.view" {{ $global_settings->premium_pos_sales_view??false?'checked':''}}/>
            <label>View Single</label>
        </li>
        <li>
            <input type="checkbox"
                   name="pos_sales.create" {{ $global_settings->premium_pos_sales_create??false?'checked':''}}/>
            <label>Create</label>
        </li>
        <li>
            <input type="checkbox"
                   name="pos_sales.update" {{ $global_settings->premium_pos_sales_update??false?'checked':''}}/>
            <label>Edit</label>
        </li>
        <li>
            <input type="checkbox"
                   name="pos_sales.delete" {{ $global_settings->premium_pos_sales_delete??false?'checked':''}}/>
            <label>Delete</label>
        </li>
        <li>
            <input type="checkbox"
                   name="pos_sales.print_barcode" {{ $global_settings->premium_pos_sales_print_barcode??false?'checked':''}}/>
            <label>Delete</label>
        </li>

    </ul>
</li>

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:10px!important;">
        <form id="createCategoryForm" method="post" action="{{ route('categories.category.store') }}" index="">
            @csrf
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <span class="text-danger font-bolder">*</span>
                                <input class="form-control" name="name" type="text" id="name"
                                       placeholder="ex. Mobile">
                            </div>
                        </div>


                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="storeCategory">
                        <span class="spinner-grow spinner-grow-sm spinner d-none" role="status" aria-hidden="true"></span>
                        Save Category
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>



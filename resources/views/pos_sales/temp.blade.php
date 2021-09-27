@foreach(range(1,5) as $number)
    <tr>
        <td style="text-align: start;max-width: 130px"><i class="fa fa-edit"
                                                          style="color: gray"></i> {{  Faker\Factory::create()->name }}
            <br>
            <small>{{ Faker\Factory::create()->name }}</small>
        </td>
        <td style="text-align: center">
            <input style="max-width: 50px" type="text"
                   class="form-control form-control-sm text-center"
                   value="205">
        </td>
        <td>
            <div class="d-flex">
                <button type="button" class="btn btn-sm btn-outline-danger "
                        style="font-weight: bolder;">
                    <span class="fa fa-trash-alt"></span>
                </button>
                <button type="button" class="btn btn-sm btn-danger " style="font-weight: bolder;">-</button>
                <input style="max-width: 50px" type="text"
                       class="form-control form-control-sm text-center mx-2"
                       value="205">
                <button type="button" class="btn btn-sm btn-primary" style="font-weight: bolder;">
                    +
                </button>
            </div>
        </td>
        <td><input type="text" value="pcs"
                   style="max-width: 30px;outline: none; border: 0px !important; text-align: end; text-decoration: underline dashed red;">
        </td>
        <td>{{ decent_format(Faker\Factory::create()->randomNumber()) }}</td>
    </tr>
@endforeach







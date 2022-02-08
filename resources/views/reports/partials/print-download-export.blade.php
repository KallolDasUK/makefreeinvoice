<div class="float-right">
    <div class="btn-group btn-group-lg float-right bg-white" role="group" aria-label="Large button group">
        <button style="color: #007337" id="exportButton" type="button" class="btn btn-outline-secondary">
            <i class="fas fa-file-excel"></i>
            <b>Export to Excel</b>
        </button>
        <button id="printBtn" type="button" class="btn btn-outline-secondary">
            <i class="fa fa-print text-danger"></i>
            <b>Print Receipt</b>
        </button>
        <button id="downloadBtn" type="button" class="btn btn-outline-secondary">
            <i class="fa fa-download text-primary"></i>

            <b>Download</b>
        </button>

    </div>

</div>
<script>


    $(document).ready(function () {
        $('#exportButton').on('click', function () {
            $("table").table2excel({
                exclude: ".excludeThisClass",
                name: "Worksheet Name",
                filename: $(document).find("title").text()+ ""+$.datepicker.formatDate('yy/mm/dd', new Date()) + ".xls", // do include extension
                preserveColors: true // set to true if you want background colors and font colors preserved
            });
           // exportToExcel($('#invoice-container').html())
        })

    })
</script>

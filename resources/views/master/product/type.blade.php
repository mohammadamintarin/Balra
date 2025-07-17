<script>
    $('#typesSelect').selectpicker({
        'title' : 'انتخاب مدل'
    });
    $('#brandSelect').selectpicker({
        'title' : 'انتخاب برند'
    });
    $('#tagSelect').selectpicker({
        'title' : 'انتخاب تگ'
    });
    $('#categorySelect').selectpicker({
        'title' : 'انتخاب دسته‌بندی'
    });
    $('#brandSelect').on('changed.bs.select', function () {
        let brandSelected = $(this).val();
        let types = @json($types);
        let typesSelect = [];
        types.map((type) => {
            if (type.brand_id == brandSelected) {
                typesSelect.push(type);
            }
        });
        $("#typesSelect").find('option').remove();
        typesSelect.forEach((element) => {

            let attributeFilterOption = $("<option/>", {
                value: element.id,
                text: element.name,
            });
            $("#typesSelect").append(attributeFilterOption);
            $("#typesSelect").selectpicker('refresh');
        });
    });
</script>

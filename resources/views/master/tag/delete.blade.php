@section('script')
    <script>
        function deleteItem(itemId , itemName , itemToken){
            var id = itemId;
            let url = '{{ route("master.tag.destroy", ['tag' => ":ItemId" ]) }}';
            var token = itemToken;
            var name = itemName;
            url = url.replace(':ItemId', id);
            Swal.fire({
                title: 'از حذف این مورد اطمینان دارید؟',
                text: " حذف" + " '" + name + "' " +"غیر قابل بازگشت خواهد بود",
                type: 'warning',
                icon:"warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله مطمئنم!',
                cancelButtonText: 'انصراف',
            }).then((result) => {
                if (result.value)
                {
                    $.post({
                        url:url,
                        data: {_method: 'delete', _token :token},
                        success:function(response)
                        {
                            $('.item'+id).remove();
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true,
                                    "positionClass": "toast-bottom-left",
                                }
                            toastr["error"](name + "  " + "حذف شد!")
                        }
                    })
                }
                location.reload();
            })
        };
    </script>
@endsection


@extends('layout.app')

@section('title','Saved')

@section('content')
    <div class="row mt-2 image-container">

    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.search').click(function (){
            let searchInput = $(".search-input").val()
            if(searchInput){
                $.ajax({
                    type: "GET",
                    url: "/images/search",
                    data: {searchInput},
                    success: function (response){
                        if (response.status === 200){
                            let html = ''
                            $.each(response.data.content.hits, function (key, val){
                                html += `<div class="col-4 mb-2">
                                            <div class="card" style="width: 25rem;">
                                                <img src="${val.webformatURL}" class="card-img-top" alt="${val.tags}">
                                                <div class="card-body">
                                                    <a href="javascript:void()" class="btn btn-success btn-sm float-right download"
                                                       data-link="${val.largeImageURL}">
                                                            Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>`
                            })
                            $('.image-container').empty().append(html)

                            let remainingTime = response.data.remaining_time;

                            if(remainingTime > 0){
                                toastr.info(new Date(remainingTime * 1000).toISOString().substr(11, 8) + ' time has left for this search')
                            }
                        }
                    }
                })
            }
        })

        $(document).on('click','.download', function (){
            let url = $(this).data('link')

            $.ajax({
                url: '/images/store',
                method:'POST',
                responseType: 'blob',
                data: {url},
                success: function (response){
                    toastr.success('Image will save shortly')
                }
            })
        })
    </script>
@endsection

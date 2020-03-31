<!DOCTYPE html>
<html>
<head>
    <title>Laravel File Upload</title>
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
</head>
<body>
<div class="container">

    <h3 class="jumbotron">Laravel File Upload</h3>
    <form method="post" action="{{url('files/upload/store')}}" enctype="multipart/form-data"
          class="dropzone" id="dropzone">
        @csrf
    </form>
    <script type="text/javascript">
        Dropzone.options.dropzone =
            {
                maxFilesize: 12,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time+file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.psd",
                addRemoveLinks: true,
                timeout: 50000,
                removedfile: function(file)
                {
                    var name = file.upload.filename;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route('files.delete') }}',
                        data: {filename: name},
                        success: function (data){
                            console.log("File has been successfully removed!!");
                        },
                        error: function(e) {
                            console.log(e);
                        }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },

                success: function(file, response)
                {
                    console.log(response);
                },
                error: function(file, response)
                {
                    return false;
                }
            };

    </script>
    @if(!$items->isEmpty())
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th scope="col">Files</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>


            <tr>
                @foreach($items as $item)
                <td>{{$item->filename}}</td>
                <td>
                    <form action="{{ route('files.delete' )}}" method="post">
                        @csrf
                        <button class="btn btn-danger" name="filename" value="{{$item->filename}}" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
@endforeach
        </tbody>
        @endif
    </table>
</div>
</div>
</body>
</html>
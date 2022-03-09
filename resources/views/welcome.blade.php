<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
        }

        #dynamic-ar {
            transform: translate(1113px, 1px);
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="{{ url('store-input-fields') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <p>{{ Session::get('success') }}</p>
            </div>
            @endif
            <table>
                <td><button type="button" name="add" id="dynamic-ar" class="btn btn-primary">Add</button></td>
            </table>
            <br>
            <table class="table table-bordered" id="dynamicAddRemove">
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>COUNTRY</th>
                    <th>STATE</th>
                    <th>IMAGE</th>
                </tr>

            </table>
            <button type="submit" class="btn btn-outline-success btn-block" style="float: right;">Save</button>
        </form>
    </div>
</body>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var i = 0;
        var increment = 0;

        $("#dynamic-ar").click(function() {
            ++i;
            increment = i;
            $("#dynamicAddRemove").append('<tr><td>'+increment+'</td><td><input type="text" name="name[]" placeholder="Enter name" class="form-control"  required/></td><td><select name="countryId[]" data-text="country" class="form-control" id="country' + increment + '" required><option>Select Country</option>@foreach($country as $data)<option value="{{$data->id}}">{{$data->countryName}}</option>@endforeach</select></td><td><select name="stateId[]" data-text="state" class="form-control" id="state' + increment + '" required><option value="">Select State</option></select></td><td><input type="file" multiple name="image[]" class="form-control" required/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button><td></tr>');
        });
        $(document).on('click', '.remove-input-field', function() {
            $(this).parents('tr').remove();
        });


        $(this).change(function(event) {
            // console.log(event.target.getAttribute("data-text"));
         
            if (event.target.getAttribute("data-text") == 'country') {
                reset();
                country = $("#" + event.target.id).val();
                console.log(country)
                $.ajax({
                    type: "GET",
                    url: "http://127.0.0.1:8000/place/" + country,

                    success: function(data) {
                        dataBind(data);
                    },
                    error: function(error) {
                        console.log('error', error);
                    }
                });
            }


        });

        function dataBind(data) {
            // console.log(increment);
         
            $.each(data.state, function(i, item) {
                var $select = $('<option>').attr({
                    value: item.id
                }).text(item.stateName);
                $select.wrap('<option>').appendTo('#state' + increment);
            });
        }

        function reset() {
            $('#state' + increment).empty();
        }
    });
</script>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <form action="{{ url('store-input-fields') }}" method="POST">
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

                    <th>NAME</th>
                    <th>COUNTRY</th>
                    <th>STATE</th>
                    <th>IMAGE</th>
                </tr>
                <tr>

                    <td><input type="text" name="name" placeholder="Enter name" class="form-control"  required/>
                    </td>
                    <td><select name="countryId" class="form-control" id="country" required>
                            <option>Select Country</option>
                            @foreach($country as $data)
                            <option value="{{$data->id}}">{{$data->countryName}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><select name="stateId" class="form-control" id="state" required>
                            <option>Select State</option>
                        </select>
                    </td>
                    <td><input type="file" name="image" class="form-control" required/>
                    </td>

                </tr>
                
            </table>
            <button type="submit" class="btn btn-outline-success btn-block">Save</button>
        </form>
    </div>
</body>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function() {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="name" placeholder="Enter name" class="form-control"  required/></td><td><select name="countryId" class="form-control" id="country" required><option>Select Country</option>@foreach($country as $data)<option value="{{$data->id}}">{{$data->countryName}}</option>@endforeach</select></td><td><select name="stateId" class="form-control" id="state" required><option>Select State</option></select></td><td><input type="file" name="image" class="form-control" required/></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button><td></tr>');
    });
    $(document).on('click', '.remove-input-field', function() {
        $(this).parents('tr').remove();
    });

    $(document).ready(function() {
        $('#country').change(function() {
            reset();
            country = $('#country').val();

            $.ajax({
                type: "GET",
                url: "http://127.0.0.1:9000/place/" + country,

                success: function(data) {
                    console.log('success', data);
                    dataBind(data);
                },
                error: function(error) {
                    console.log('error', error);
                }
            });

        });

        function dataBind(data) {
            $.each(data.state, function(i, item) {
                console.log(item.id);
                var $select = $('<option>').append(
                    $('<p>').attr({
                        value: item.id
                    }).text(item.stateName)
                );
                $select.wrap('<option>').appendTo('#state');
            });
        }

        function reset() {
            $('#state').empty();
        }
    });
</script>

</html>
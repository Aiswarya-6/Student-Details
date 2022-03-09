<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div>
            <a class="btn btn-primary" href="{{ url('/') }}">Back to form</a>
        </div>
        <table class="table table-bordered" id="dynamicAddRemove">
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>COUNTRY</th>
                <th>STATE</th>
                <th>IMAGE</th>
            </tr>
            @foreach($response as $data)
            @if($data->country == null)
            @continue
            @endif
            @if($data->state == null)
            @continue
            @endif
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->country->countryName}}</td>
                <td>{{$data->state->stateName}}</td>
                <td><img src="{{$data->image}}" alt="" style="width:80px;"></td>

            </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
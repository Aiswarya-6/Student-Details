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
        <table class="table table-bordered" id="dynamicAddRemove">
            <tr>

                <th>NAME</th>
                <th>COUNTRY</th>
                <th>STATE</th>
                <th>IMAGE</th>
            </tr>
            <tr>
@foreach($response as $sata)
                <td>$data->name</td>
                <td>$data->country->countryName</td>
                <td>$data->state->stateName</td>
                <td>$data->image</td>
@endforeach
            </tr>
        </table>
    </div>
</body>

</html>
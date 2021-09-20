<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>

<body>
    <div class="container mt-5">

        <table class="table table-bordered mb-5">
            <thead>
                <tr>
                    @foreach ($export['headers']??[] as $key => $item)
                        <th scope="col">
                            <strong>{{ucwords(str_replace('_',' ', $item))}}</strong>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($export['data'] ?? [] as $value)
                <tr>
                    
                    @foreach ($value?? [] as $colItem)
                        <td scope="row">
                            {{ $colItem?? '-' }}
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</body>

</html>
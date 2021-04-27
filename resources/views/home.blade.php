<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search for Covid19 Data</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-green-50 via-blue-50 to-green-50">
<div class="w-4/12 mx-auto mt-20">
    <div class="text-gray-700 text-l font-bold">Get last information about region</div>
    <form method="post">
        <label for="region">Region</label>
        <input type="text" id="region" name="region"
               class=" bg-transparent border border-gray-500 rounded  w-1/2 text-gray-700 mr-3 py-1 px-2 leading-tight"
               placeholder="Rīga" aria-label="region"><br><br>
        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" type="submit"
               value="Submit">
        @csrf
    </form>
    @if($data === 'home')
    @elseif($data === null)
        <div class="text-gray-700 text-l font-bold">Invalid region</div>
    @else
        <div class="text-gray-700 text-l font-bold">
            Region : {{$data->region_name}} <br>
            Confirmed infection count: {{ $data->confirmed_infection }}<br>
            Active infection count: {{ $data->active_infection }}<br>
            14 day cumulative: {{ $data->{'14_day_cumulative'} }}<br>
            Date updated: {{$data->registration_date}}
        </div>
    @if(time() - strtotime($data->registration_date) > 604800)
            <div class="mt-10 text-gray-700 text-l font-bold"> If you want to update database, use BackEnd option!</div>
        @else
            <div class="mt-10 text-gray-700 text-l font-bold"> Update can take a while. Be patient!</div>
            <form method="post" action="/update">
                <input class="mt-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" type="submit"
                       value="Update database" alt="Updating can take a while!">
                @csrf
            </form>
        @endif
    @endif
</div>
</body>
</html>

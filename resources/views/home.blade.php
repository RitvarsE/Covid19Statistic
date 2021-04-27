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
    <div class="mb-2 text-gray-700 text-l font-bold">Get last information about region</div>
    <div class="relative inline-flex">
    <select class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" id="region" name="region" form="regionselect">
        @foreach($regions as $region)
            <option value="{{$region->region_name}}">{{ $region->region_name }}</option>
        @endforeach
    </select>
</div>
    <form method="post" id="regionselect">
        <label for="region">Region</label>
        <input class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" type="submit"
               value="Submit">
        @csrf
    </form>
    @if($data === 'home')
    @elseif($data === null)
        <div class="text-gray-700 text-l font-bold">Invalid region</div>
    @else
        Region :
        <div class="display: inline text-gray-700 text-l font-bold">{{$data->region_name}}</div> <br>
        Confirmed infection count:
        <div class="display: inline text-gray-700 text-l font-bold">{{ $data->confirmed_infection }}</div><br>
        Active infection count:
        <div class="display: inline text-gray-700 text-l font-bold">{{ $data->active_infection }}</div><br>
        14 day cumulative:
        <div class="display: inline text-gray-700 text-l font-bold">{{ $data->{'14_day_cumulative'} }}</div><br>
        Date updated:
        <div class="display: inline text-gray-700 text-l font-bold">{{$data->registration_date}}</div>
        @if(time() - strtotime($data->registration_date) > 604800)
            <div class="mt-10 text-gray-700 text-l font-bold"> Database is pretty old. If you want to update database, you need to ask provider to update it! Contact:</div><a href="mailto:statisticadmin@statistic.com">statisticadmin@statistic.com</a>
        @elseif(time() - strtotime($data->registration_date) < 2*86400)
            <div class="mt-10 text-gray-700 text-l font-bold"> You are up to latest data!</div>
        @else
            <div class="mt-10 text-gray-700 text-l font-bold"> Update can take a while. Be patient!</div>
            <form method="post" action="/update">
                <input class="mt-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
                       type="submit"
                       value="Update database" alt="Updating can take a while!">
                @csrf
            </form>
        @endif
    @endif
</div>
</body>
</html>

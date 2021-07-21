<!doctype html>
<html>
  <head>
    <title>Machine Test</title>
  </head>
  <body>
    <a href="{{url('/upload/csv')}}">Import CSV</a>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Module Code</th>
                <th>Module Name</th>
                <th>Module Term</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $key => $item)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->modulecode}}</td>
                <td>{{$item->modulename}}</td>
                <td>{{$item->moduleterm}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </body>
</html>
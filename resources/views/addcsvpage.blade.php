<!doctype html>
<html>
  <head>
    <title>Machine Test</title>
  </head>
  <body>
    <a href="{{url('/list/csv_data')}}">Back</a>
     <!-- Message -->
     @if(Session::has('error'))
        <p style="Color:red;">{{ Session::get('error') }}</p>
    @endif

     <!-- Form -->
     <form method='post' action="{{url('/store/csv/data')}}" enctype='multipart/form-data' >
       {{ csrf_field() }}
       <label for="file"><b>Select the CSV file with relevant data</b></label><br>
       <div class="custom-file">
            <input type="file" accept=".csv" name="file" class="form-control" id="customFile" />
            <div style="color:red">{{$errors->first('file')}}</div>
        </div>
        <input type='submit' name='submit' value='Submit'>
     </form>

     
  </body>
</html>
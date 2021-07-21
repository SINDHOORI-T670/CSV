<p>Hi Charush,</p>
<p>Errors from Validation</p>
<center>

    @if (count($errors) > 0)
        <ul style="list-style-type:none">
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif


</center>

<strong>Good Luck ! <br> </strong>

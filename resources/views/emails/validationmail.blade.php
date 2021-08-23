<p>Hi Charush,</p>
<p>Errors from Validation</p><br>
------------------------------<br>
    @if (count($errors) > 0)
        <ul style="list-style-type:none">
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

<strong>Good Luck ! <br> </strong>

<!DOCTYPE html>
<html>
<head>
<title>Title of the document</title>
<link rel="stylesheet" type="text/css" href="../../css/app.css">

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!--bootstrap stuff-->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


<!--ajax stuff-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


@yield('style')
</head>
@yield("navbar")
@yield('script')

<body>
    @yield("content")
</body>

</html>
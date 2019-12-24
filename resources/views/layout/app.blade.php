<html>
<head>
<title>For Basic Web Site</title>
@stack('css')
</head>
<body>

@yield('content')

@section('sidebar')


<div class="sidebar">
<h3 style="color:blue;">sidebar</h3>
 this is the sidebar
  
</div>
@stack('js')
</body>

</html>
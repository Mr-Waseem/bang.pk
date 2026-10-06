@include("/include.config")
<?php 
$conn = DB::connection()->getPdo();
  $que=$conn->query('SELECT * from system_logos')->fetch();
  $quee=$conn->query('SELECT * from settings')->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from g-axon.com/mouldifi-3.0/dark/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Nov 2016 11:02:52 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Mouldifi - A fully responsive, HTML5 based admin theme">
<meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, Mouldifi, web design, CSS3">
<title><?php echo $quee['title']; ?></title>
<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='\upload\logo\<?php echo $que['image']; ?>' />
<!-- /site favicon -->

<!-- Entypo font stylesheet -->
<link href="css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi core stylesheet -->

<link href="css/mouldifi-forms.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
<![endif]-->

</head>
<body class="login-page">
<div class="login-container">
    <div class="login-branding">
        <a href="index.html"><img src="\upload\logo\<?php echo $que['image']; ?>" style="height: 80px;" alt="<?php echo $quee['title']; ?>" title="<?php echo $quee['title']; ?>"> </a>
    </div>
    <div class="login-content">
        <h2>Create an account</h2>
        <form class="form-horizontal" role="form" method="POST" file="true" enctype="multipart/form-data" action="{{ url('/register') }}">
        {{ csrf_field() }}                        
            <div class="form-group">
                <input id="name" type="text" placeholder="Name" style="color:white;" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>   
            <div class="form-group">
                <input id="email" type="email" placeholder="Email" style="color:white;" class="form-control" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>                     
            <div class="form-group">
                <input id="password" type="password" placeholder="Password" style="color:white;" class="form-control" name="password" required>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" placeholder="Confirm Password" style="color:white;" class="form-control" name="password_confirmation" required>
            </div>
            <div class="form-group form-action">
                <button type="submit" class="btn btn-primary btn-block">Regsiter</button>
            </div>
            <p class="text-center">Have an account <a href="/login">Sign in</a></p>                        
        </form>
    </div>
</div>
<!--Load JQuery-->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

<!-- Mirrored from g-axon.com/mouldifi-3.0/dark/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Nov 2016 11:02:52 GMT -->
</html>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    

    <title>NTS Training</title>
    <link href="lib/jquery/jquery.css" rel="stylesheet" type="text/css"/>
    <script src="lib/jquery/jquery_v152.js"></script>
    <script src="lib/jquery/jquery-ui.min.js"></script>

    <script type="text/javascript" src="presentation/content/view/js/script/validation.min.js"></script>
    <script type="text/javascript" src="presentation/content/view/js/script/login.js"></script>
    <link href="presentation/content/view/css/style.css" rel="stylesheet" type="text/css" media="screen">
</head>
<div class="container">
    <?php ?>
    <div class="form-sp"></div>
    <form class="form-login" method="post" id="login-form">
        <h2 class="form-login-heading text-center">Log In</h2>
        <hr />
        <div id="error">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="trainee" id="user_id" />
            <span id="check-e"></span>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="identifier" id="graDuration" />
        </div>
        <hr />
        <div class="form-group">
            <!--                <div class="col-sm-5"><a href="home.php?eid=guest" id="guest-access"> Guest Access</a>-->
            <!--                </div>-->
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-default" name="login_button" id="login_button">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                </button>

            </div>

        </div>
    </form>
</div>
<div class="insert-post-ads1" style="margin-top:20px;">
</div>
</div>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<?php
require('bdd.php');

?>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Facebook Theme Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="styles/css/bootstrap.css" rel="stylesheet">
    <link href="styles/css/facebook.css" rel="stylesheet">
</head>

<body>

    <div class="wrapper">

        <div class="column col-sm-12 col-xs-11" id="main">

            <div class="navbar navbar-blue navbar-static-top">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand logo">b</a>
                </div>
                <nav class="collapse navbar-collapse" role="navigation">
                    <form class="navbar-form navbar-left">
                        <div class="input-group input-group-sm" style="max-width:360px;">
                            <input name="" class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="./index.php"><i class="glyphicon glyphicon-home"></i> Home</a>
                        </li>
                        <li>
                            <a href="./post.php" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Post</a>
                        </li>
                        <li>
                            <a href="#"><span class="badge">badge</span></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="">More</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="padding">
                <div class="full col-sm-9">

                    <div class="row">

                        <div class="col-sm-5">

                            <div class="panel panel-default">
                                <div class="panel-thumbnail"><img src="media/img/bg_5.jpg" class="img-responsive"></div>
                                <div class="panel-body">
                                    <p class="lead">CFPT</p>
                                    <p>45 Followers, 13 Posts</p>

                                    <p>
                                        <img src="media/img/uFp_tsTJboUY7kue5XAsGAs28.png" height="28px" width="28px">
                                    </p>
                                </div>
                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading"><a href="#" class="pull-right">View all</a>
                                    <h4>Bootstrap Examples</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item">Modal / Dialog</a>
                                        <a href="#" class="list-group-item">Datetime Examples</a>
                                        <a href="#" class="list-group-item">Data Grids</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-7">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2>Welcome</h2>
                                </div>
                            </div>
                            <?php echo PostAndMediaToCarousel(); ?>

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p class="lead">Social Good</p>
                                    <p>1,200 Followers, 83 Posts</p>

                                    <p>
                                        <img src="media/img/photo.jpg" height="28px" width="28px">
                                        <img src="media/img/photo.png" height="28px" width="28px">
                                        <img src="media/img/photo_002.jpg" height="28px" width="28px">
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row" id="footer">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <p>
                        <a href="#" class="pull-right">Nieva Mathias Copyright 2022</a>
                    </p>
                </div>
            </div>
            <hr>
            <script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('[data-toggle=offcanvas]').click(function() {
			$(this).toggleClass('visible-xs text-center');
			$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
			$('.row-offcanvas').toggleClass('active');
			$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
			$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
			$('#btnShow').toggle();
		});
	});
</script>

</body>

</html>
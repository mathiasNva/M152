<!DOCTYPE html>
<html lang="en">

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
                            <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
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
                        <div class="well">
                            <form class="form-horizontal" role="form" action="uploadFile.php" method="post" enctype="multipart/form-data">
                                <h4>Faire un post</h4>
                                <div class="form-group" style="padding:14px;">
                                    <textarea id="commentaire" name="commentaire" class="form-control" placeholder="Ajouter du text"></textarea>
                                </div>
                                <input type="file" class="btn btn-primary" name="filesToUpload[]" multiple accept="image/jpg, image/jpeg, image/png, image/PNG, image/JPG, video/vmp4, video/m4v, video/*, audio/mp3, audio/ogg, audio/*, audio/mpeg">
                                <input type="submit" name="submit" class="btn btn-primary" value="Post">
                            </form>
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
</body>

</html>
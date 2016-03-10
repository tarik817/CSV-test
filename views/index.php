<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>File board</title>

    <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo BASE_URL ?>">Board site</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo BASE_URL ?>">Home</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="margin-top:55px;">
      <div class="content">
        <div class="row">
          <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                  <form id="add_post_form" enctype="multipart/form-data" method="post" action="<?php echo BASE_URL . '/starage/proccess' ?>">
                    <div class="form-group">
                      <label for="exampleInputFile">File input</label>
                      <input name="file[]" type="file" id="InputFile">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                  </form>
                </div>
              <div id="board">
              <hr>
                <table class="table"> 
                  <caption>Products in storages.</caption> 
                  <thead> 
                    <tr> 
                      <th>Product name</th>
                      <th>Quantity</th> 
                      <th>Storage place</th> 
                    </tr> 
                  </thead> 
                  <tbody>
                    <?php foreach ($data['storage'] as $record) { ?> 
                      <tr> 
                        <td><?= $record['product_name'] ?></td> 
                        <td><?= $record['qty_sum'] ?></td> 
                        <td>
                          <?php foreach ($record['warehouse'] as $place) { ?> 
                              <?= $place['warehouse'] ?>
                          <?php } ?>
                        </td> 
                      </tr>
                    <?php } ?>
                  </tbody> 
                </table>
              </div>
            </div>
          </div>
        </div>

      </div><!-- /.content -->
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript"  src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript"  src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </body>
</html>

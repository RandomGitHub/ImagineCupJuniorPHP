<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>My Recipe List</title>

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body {
      padding-top: 70px;
      /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">My Recipe List</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li>
            <a href="#">About</a>
          </li>
          <li>
            <a href="#">Services</a>
          </li>
          <li>
            <a href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Select List -->


  <!-- Page Content -->
  <div class="container">
    <form class="form" role="form" method="POST" action="<?php ECHO $_SERVER['PHP_SELF']; ?>">
      <div class="well well-sm row">

        <div class="col-sm-1">
          <select class="form-control" name="selRecipeName">
            <option value="is">is</option>
            <option value="not">not</option>
          </select>
        </div>
        <div class="col-sm-2">
          <input type="text" class="form-control" name="txtRecipeName" placeholder="Recipe Name">
        </div>


        <div class="col-sm-1">
          <select class="form-control" name="selRecipeType">
            <option value="is">is</option>
            <option value="not">not</option>
          </select>
        </div>
        <div class="col-sm-2">
          <input type="text" class="form-control" name="txtRecipeType" placeholder="Recipe Type">
        </div>

        <div class="col-sm-2">
          <select class="form-control" name="selServes">
            <option value="least">at least</option>
            <option value="most">at most</option>
            <option value="exact">exactly</option>
          </select>
        </div>
        <div class="col-sm-2">
          <input type="number" min="1" class="form-control" name="numServes" placeholder="Serves">
        </div>
        <div class="col-sm-2">
          <button type="submit" name="submitForm" class="btn btn-info pull-right">Search</button>
        </div>
      </div>
    </form>
    <div class="panel panel-primary">
      <div class="panel-heading">Recipes</div>
      <div class="table-responsive">
        <table class="table table-condensed table-bordered table-hover">
          <thead>
            <tr>
              <th>Recipe Name</th>
              <th>Recipe Type</th>
              <th>Serves</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if(isset($_POST["submitForm"])) {
                $servername = //"CHANGEME";
                $username = //"CHANGEME";
                $password = //"CHANGEME";
                $dbname = //"CHANGEME";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection Error: ".$conn->connect_error);
                }
                $sqlQuery = 'SELECT * from recipes';

                $recipeName     = mysqli_real_escape_string($conn, $_POST["txtRecipeName"]);
                $selRecipeName  = ($_POST["selRecipeName"] == "not") ? "NOT LIKE" : "LIKE";
                $sqlQuery .= ' WHERE recipes.RecipeName '.$selRecipeName.' "%'.$recipeName.'%"';

                $recipeType     = mysqli_real_escape_string($conn, $_POST["txtRecipeType"]);
                $selRecipeType  = ($_POST["selRecipeType"] == "not") ? "NOT LIKE" : "LIKE";
                $sqlQuery .= ' AND recipes.RecipeType '.$selRecipeType.' "%'.$recipeType.'%"';

                $selServes  = ($_POST["selServes"] == "exact") ? "=" : ($_POST["selServes"] == "most") ? "<=" : ">=";
                $serves     = intval($_POST["numServes"]) > 0 ? intval($_POST["numServes"]): 1;
                $sqlQuery .= ' AND recipes.Serves '.$selServes.' '.$serves;

                $sqlQuery .= ' ORDER BY recipes.RecipeName ASC;';


                $result = $conn->query($sqlQuery);
                ECHO '<tr> <td colspan="3"> <span class="label label-info">'.$result->num_rows.' results found </span></td></tr>';
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    ECHO  '<tr>
                            <td>'.$row["RecipeName"].'</td>
                            <td>'.$row["RecipeType"].'</td>
                            <td>'.$row["Serves"].'</td>
                          </tr>';
                  }
                }
                $conn->close();
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /.container -->

  <!-- jQuery Version 1.11.1 -->
  <script src="js/jquery.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>

</body>

</html>

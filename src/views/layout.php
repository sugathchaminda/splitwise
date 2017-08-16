<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Split Bill Wise</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="src/js/splitBill.js"></script>
    </head>
    <body>
        <header>
            <a href='#'>Home</a>
        </header>
        <nav  class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-brand">Split Bill Wise</div>
            </div>
        </nav>
        <div class="container">
            <form class="split-bill-form" action="routes.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6 col-md-12 col-lg-2">
                        <label id="errorLabel" class="alert-danger"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-2">
                        <textarea name="jsonInput" id="jsonInput" cols="50" rows="5" class="">
                        </textarea>
                        <br/>
                        <input id="jsonUpload" name="jsonUpload" type="button" class="btn btn-lg btn-primary" value="Add Bill Info">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <h2>
                            <span class="label label-default">No Of Days :</span>
                            <span id="noOfDaysLbl" class="label label-default"></span>
                        </h2>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <h2>
                            <span class="label label-default">Total Amount spent :</span>
                            <span id="totalAmountLbl" class="label label-default"></span>
                        </h2>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="panel panel-info col-sm-6 col-md-6">
                        <h2>Amount Spent By Each User</h2>
                        <div class="user-spent-panel panel-body">
                            <ul class="user-spent-ul">
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-info col-sm-6 col-md-6">
                        <h2>Users Owe Amounts</h2>
                        <div class="user-owe-panel panel-body">
                            <ul class="user-owe-ul">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <h2>User Settlements</h2>
                            <ul class="user-settlement-ul">
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <footer>
                            <p></p>
                        </footer>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

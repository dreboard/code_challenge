<?php
require_once __DIR__.'/init.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>By Month Report <?php echo $month; ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 54px;
        }
        @media (min-width: 992px) {
            body {
                padding-top: 56px;
            }
        }

    </style>

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Code Challenge</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ext" href="https://github.com/dreboard/code_challenge">Source</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ext" href="./docs/index.html">Docs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ext" href="./coverage/index.html">Coverage</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mt-5">Transaction Report for <?= $month, ' ', date('Y'); ?></h1>
            <p class="lead"><a href="index.php?m=Jan">Jan</a> | <a href="index.php?m=Feb">Feb</a> | <a href="index.php?m=Mar">Mar</a></p>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Program</th>
                    <th scope="col">Transactions</th>
                    <th scope="col">Deposits</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Fee</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($display as $data) {
                    echo "<tr>
                        <th scope='row'>" . (int)$data['id'] . "</th>
                        <td>$" . htmlspecialchars($data["initial"], ENT_QUOTES) . "</td>
                        <td>" . htmlspecialchars($data["program"], ENT_QUOTES) . "</td>
                        <td>" . htmlspecialchars($data["transactions"], ENT_QUOTES) . "</td>
                        <td>$" . htmlspecialchars($data["deposits"], ENT_QUOTES) . "</td>
                        <td>$" . htmlspecialchars($data["balance"], ENT_QUOTES) . "</td>
                        <td>$" . (int)max($data["fees"]). "</td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    (function () {
        $(document).ready(function () {
            var LinkTest = {};
            LinkTest.externalLinks = function () {
                $('a.ext').click(function () {
                    window.open(this.href);
                    return false;
                });
            }();
        });
    })(jQuery);
</script>
</body>

</html>
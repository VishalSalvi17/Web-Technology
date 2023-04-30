<html>
    <head>
        <title>Fruit Poll Results</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <center><h1 style="padding-top: 20px;"><b>Favourite Fruit Poll Results<b></h1></center>
        <hr style="margin-bottom: 30px; margin-top: 0;">
        <div class="container-fluid">
            <div class="table-responsive-lg">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Fruit</th>
                            <th scope="col">Votes</th>
                            <th scope="col">Vote percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo($table_rows);?>
                    </tbody>
                </table>
            </div>
            <center><a href="opinion.html.php" class="btn btn-info" role="button">Vote again</a></center>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</html>

<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <script type="text/javascript">
        function hello(){
            alert('Hello');
        }
    </script>
    <body>
        <div class='container'>
            <h2>Admins In This System</h2>
            <div class='panel-group'>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <h4 class='panel-title'>
                            <a data-toggle='collapse' href=#collapse1>Feroz Ahmmed</a>
                            <button style='border: 0px' onclick='hello()'><span class="glyphicon glyphicon-trash"></span></button>
                        </h4>
                    </div>
                    <div id=collapse1 class='panel-collapse collapse'>
                        <ul class='list-group'>
                            <li class='list-group-item'>Student</li>
                            <li class='list-group-item'>froghramar@gmail.com</li>
                        </ul>
                    </div>
                </div>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <h4 class='panel-title'><a data-toggle='collapse' href=#collapse2>Nazmul Haque</a></h4>
                    </div>
                    <div id=collapse2 class='panel-collapse collapse'>
                        <ul class='list-group'>
                            <li class='list-group-item'>Student</li>
                            <li class='list-group-item'>nazmul0635iit@gmail.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
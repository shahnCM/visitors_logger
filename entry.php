<?php
session_start();

// Deleting Sessions
function unset_session($session_name)
{
  if(isset($_SESSION['log'])) 
  {
    unset($_SESSION[$session_name]);
  }
}

// Initializing sessions
function set_session($session_name, $session_value)
{  
  $_SESSION[$session_name] = $session_value;
}

// Get the session data
function get_session($name)
{
  return $_SESSION[$name];
}

// Check if session exits
function check_session($name)
{
  if(isset($_SESSION[$name])){
    // var_dump($_SESSION[$name]);
    return true;
  }
}

// Redirecting to a new page
function redirect($page_url)
{
    header('Location: ' . $page_url);
}

// Log Visitors
function log_visitors($data) 
{
  $log = [];
  if(check_session('log'))
  {
    $log = get_session('log');
  } 
  array_push($log, (object)$data);
  // unset_session('log');
  set_session('log', $log);
  // echo(get_session('log')[0]->visitors_name);
}

// Taking action on $_POST
if (isset($_POST['submit'])) 
{
  log_visitors($_POST);
}

// Taking action on $_GET
if (isset($_GET['delete_log']))
{
  unset_session('log');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhpSessions</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">
        <h3 class="text-center text-secondary pt-3">Visitor's Logger</h3>
        <hr>
        <div class="d-flex justify-content-center">
            <div class="p-4">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    
                    <div class="row d-flex justify-content-center">
                    
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="visitors_name">Visitor's Name</label>
                            <input type="text" class="shadow-sm form-control" id="visitors_name" name="visitors_name">
                        </div>  
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="phone">Visitor's Phone</label>
                            <input type="text" class="shadow-sm form-control" id="phone" name="phone">
                        </div>  
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="visiting_time">Visiting Time</label>
                            <input type="time" class="shadow-sm form-control" id="time" name="visiting_time">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="visiting_date">Visiting Date</label>
                            <input type="date" class="shadow-sm form-control" id="date" name="visiting_date">
                        </div>
                      </div>
                      
                      <!-- 
                      <div class="form-group">
                          <label for="visiting">Visiting</label>
                          <textarea name="visiting" class="form-control shadow-sm" id="visiting" cols="40" rows="3"></textarea>
                      </div>                     
                      -->
                    
                    </div>
                    
                    <br>
                    
                    <div class="row d-flex justify-content-center">
                      
                      <div class="p-2">
                        <button class="border-0 shadow btn-sm btn-danger" type="get">
                          <a href="./entry.php?delete_log" class="text-decoration-none text-white" name="delete_logs">Delete Logs</a>
                        </button>
                      </div>
                    
                      <div class="p-2">
                        <button type="submit" class="border-0 shadow btn-sm btn-info" name="submit">Submit</button>
                      </div>

                    </div>
                    
                </form>
            </div>
        </div>

        <div class="log-table">
          <?php if(check_session('log')) { $i = 0; ?>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Time</th>
                  <th scope="col">Date</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach(get_session('log') as $item) { $i++;?>
                  <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><?php echo $item->visitors_name; ?></td>
                    <td><?php echo $item->phone; ?></td>
                    <td><?php echo $item->visiting_time; ?></td>
                    <td><?php echo $item->visiting_date; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>  
          <?php } else { ?>
            <p class="text-center text-secondary">No Log Available</p>     
          <?php } ?>       
        </div>
    </div>
</body>

</html>
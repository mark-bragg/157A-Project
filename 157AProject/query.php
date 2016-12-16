<?php

if (session_status() == PHP_SESSION_NONE) {
    	session_name("permaSess");
        session_start();
	}
if(!isset($db)){
    $db = new mysqli('p:127.0.0.1:3306', 'root', '', 'projectdb');
    //echo '<h2>New Connection</h2>';
}

echo '<div id="results">';
echo '<hr>'	;
	if (isset($_POST['qType']))
            {
                echo $_POST['qType'] . " performed" . '<br>';
                $queryType = $_POST['qType'];
                switch ($queryType)
                {
                    case "commit" :
                        $db->commit();
                        $db->close();
                        break;
                    case "rollback" :
                        $db->rollback();
                        echo 'rollback: ' . $db->rollback();
                        $db->close();
                        break;
                    case "autocommitOn" :
                        echo 'autocommit on: ' . $db->autocommit(TRUE);
                        break;
                    case "autocommitOff" :
                        echo 'autocommit off: ' . $db->autocommit(FALSE);
                        $db->begin_transaction();
                        break;
                    case "newTransaction" :
                        echo 'New Transaction: ' . $db->begin_transaction() . ' Started';
                        //$db->begin_transaction();
                        break;
                    case "Query" :
                        //$db->autocommit(FALSE);
                        $db->multi_query( $_POST['query'] ) or die('Error querying database');
                        // = mysqli_query($db, $_POST['query']);
                        $result = $db->store_result();
                        do {
                          if(!is_null($result->num_rows) && $result->num_rows > 0 ){
                              //echo $result;
                              $qInfo = $result->fetch_fields();
                              echo '<div><table style="width:100%" padding: 15px>' . '<tr>';
                              foreach($qInfo as $val){
                                  echo '<th>' . $val->name . '</th>';
                              }
                              echo '</tr>';
                              $qInfo = $result->fetch_fields();
                              while($row = $result->fetch_array()){
                                  echo '<tr>';
                                  foreach($qInfo as $val){
                                      echo '<td>' . utf8_encode($row[$val->name]) . '</td>';
                                  }
                                  echo '</tr>';
                              }
                              echo '</table></div>';
                          }
                          else if($result == TRUE){
                              echo '<div><table style="width:100%" padding: 15px>' . '<tr>';
                              echo '<th><td>' . $_POST['query'] . '</td></th></tr></table></div>';
                          }
                          echo '<br>';
                          $boolFlag = $db->next_result();
                        } while(!is_null($boolFlag) && $result = $db->store_result());

                    $db->close();
                    break;
                }
            }
    else {
      echo '<div><table style="width:100%" padding: 15px>' . '<tr><th>No Queries provided.</th></tr></table></div>';
    }
echo '</div>';



?>

<!DOCTYPE html>
<html>
<head>
	<title>transaction history</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/default_style.css">
    <link rel="stylesheet" type="text/css" href="../css/history.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <script type="text/javascript" src="hide_history.js">
    </script>
}
</head>
<body>
	<div class="frame">
		<div class="header">
			<?php
                $user_id = $_GET['id'];
                include '../database/dbconnect.php';
                
                $query=mysqli_query($con,"SELECT * FROM user WHERE user_id='".$user_id."'") or die(mysqli_error());
                
                if(mysqli_num_rows($query)!=0)
                {
                    $row=mysqli_fetch_assoc($query);
                    $username = $row['username'];
                    include("../template/header.php");
                }
            ?>
		</div>
		<div class="menu_container">
            <?php include'../template/menu.php';?>
            <script>
            	document.getElementById("history_link").setAttribute("class", "menu menu_active");
            </script>
        </div>
        <div class="history_container">
        	<div class="subheader">
        		<div class="title"><h1>Transaction History</h1></div>
        	</div>
    		<ul class="page_menu">
    			<li>
    				<a class="history_menu menu_active" href=<?php echo 'transaction_history.php?id='.$user_id; ?>>
						<h3>MY PREVIOUS ORDER</h3>
					</a>
    			</li>
    			<li>
    				<a class="history_menu" href=<?php echo 'driver_history.php?id='.$user_id; ?>>
						<h3>DRIVER HISTORY</h3>
					</a>
    			</li>
    		</ul>

    		<div id="history_table_container">
	    		<table class="history_table">
					<colgroup>
						<col style="width: 20%;">
						<col style="width: 80%;">
					</colgroup>

					<tbody>
						<?php
		                    $query_order=mysqli_query($con,"SELECT * FROM `order` WHERE `cust_id`='".$user_id."'") or die(mysqli_error($con));

		                    if(mysqli_num_rows($query_order)!=0)
		                    {
		                        while($row=mysqli_fetch_assoc($query_order)) {
			                    	$driver_query=mysqli_query($con,"SELECT username FROM user WHERE user_id='".$row['driver_id']."'") or die(mysqli_error());
			                    	$driver_row=mysqli_fetch_assoc($driver_query);
			                    	$driver_name=$driver_row['username'];
		                            echo
		                            	"<tr>
		                            		<td>
		                            			<img class='history_pict' src='../profile/getProfilePict.php?id=".$row['driver_id']."'>
		                            			<button class='hide_hist_button' type='button' value='hide' onclick='hide_row(this)'>Hide</button>
		                            		</td>
		                            		<td class='order_data'>
		                            			<p class='history_date'>".$row['date']."</p>
						    					<p class='history_username'>".$driver_name."</p>
						    					<p class='history_loc'>".$row['pick_city']." - ".$row['dest_city']."</p>
						    					<p class='history_rating'>You rated: ";
						    					
						    					for ($i = 0; $i < $row['score']; $i++) {
						    						echo "<span class='fa fa-star checked'></span>";
						    					}

						    		echo
						    					"</p>
						    					<p class='history_comment'>You commented:</p>
						    					<p class='history_comment' style='margin-left: 30px;'>".$row['comment']."</p>
		                            		</td>
		                            	</tr>";
		                        }
		                    }
		                    mysqli_close($con);
		                ?>
					</tbody>
	    		</table>
    		</div>
        </div>
	</div>
</body>
</html>

<script type="text/javascript" src="hide_history.js"></script>
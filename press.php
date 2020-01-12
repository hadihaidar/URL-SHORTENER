<link rel="stylesheet" href="style/bootstrap.css">
<?php
include "connection.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}
?>
<style>

table.blueTable {
  border: 1px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
  height: 50px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  border-left: 2px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
  background: #D0E4F5;
  background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  border-top: 2px solid #444444;
}
table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}
.btn1 {
  display: inline-block;
  padding: 6px 12px;
  margin-bottom: 0;
  font-size: 14px;
  font-weight: normal;
  line-height: 1.428571429;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  cursor: pointer;
  border: 1px solid transparent;
  border-radius: 4px;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
       -o-user-select: none;
          user-select: none;
}
.btn-primary1{
	color:#fff;
	background-color:#428bca;
	border-color:#357ebd
}
.input-group1{  height: 45px;
  padding: 10px 16px;
  font-size: 18px;
  line-height: 1.33;
border-radius: 6px;}
</style>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a class="navbar-brand">
              URL SHORTENER</a>
            </div>
            
        </div>
    </div>
	<div class ="container body-content" style="
    padding-top: 3%;
">
<h1> Hi, <?= $_SESSION['name'] ?> </h1>
<form action="login.php" method="POST" style="float:right">
    <button class="btn1 btn-primary1" name="logout" type="submit" >logout</button>
</form>
<br>
<div>
    <input id='url' type="url" placeholder="Link" class="input-group1">
    <button id='short' class="btn1 btn-primary1"  onclick="generateLink()" style="visiv"> shorten</button>
	<form action="press.php" method="POST" ><br>
	<b>API KEY:</b>
	<?php 
		$email =$db->quote($_SESSION['user']);
		if(isset($_POST['reset'])){
			$id = $db->quote(md5(uniqid().uniqid()));
			$query = $db->query("UPDATE users SET apikey=$id WHERE email=$email");
		}
		$query = $db->prepare("SELECT apikey FROM users where Email=$email ");
		$query->execute();
		echo($query->fetchColumn());
	?>
		<button class="btn1 btn-primary1" name="reset" type="submit" >RESET</button>
	</form>
	<br>
    <div id="new"> </div>
    <div id="bla"> </div>
</div>

<table class="blueTable" id="myTable">
    <thead>
        <tr>
            <th style="width: 50%;">Original</th>
            <th>Shortened</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tfoot>
        
    </tfoot>
    <tbody>
        <?php
        $query = $db->query("SELECT * FROM link");
        foreach ($query as $row) {
            if ($row['email'] == $_SESSION['user']) {
                ?>
                <tr>
                    <td><a href="<?= $row['original'] ?>" target="_blank"><?= $row['original'] ?></td>
                    <td><a href="<?= $urlink .$row['new'] ?>" target="_blank"><?=$urlink .$row['new'] ?></td>
                    <td style="text-align:center"><button class="btn1 btn-primary1" id="delete" onclick="del('<?=$row['new']?>')">DELETE</button></td>
                </tr>
            <?php }
        }
        ?>
    </tbody>
</table>
</div>
</body>
<script>
    //send ajax request to shorten the url
    function generateLink() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('new').innerHTML = "<a href="+this.responseText+"target='_blank'>"+this.responseText+"</a>" + "<button class='btn1 btn-primary1' id='copy' type='button'  onclick='copy()'>copy</button><br>";
            }
        };
        xhttp.open("post", 'shorten.php' , true);
		var data = new FormData();
         data.append('url', document.getElementById("url").value);
        xhttp.send(data);
    }

    function copy() {
        var range = document.createRange();
        range.selectNode(document.getElementById("new"));
        window.getSelection().removeAllRanges(); // clear current selection
        window.getSelection().addRange(range); // to select text
        document.execCommand("copy");
        window.getSelection().removeAllRanges(); // to deselect
     
    }
    
    function del(id) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    window.location.reload();
                }
            };
            xhttp.open('post', 'delete.php' , true);
    		var data = new FormData();
            data.append('url', ''+id);
            xhttp.send(data);
    }
</script>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" >
	<meta name="description" content="">
	<title>タイトル</title>
	<link rel="stylesheet" type="text/css" href="text.css">
</head>
<body>

	<div class="header">
		<img src="画像のファイル名" id="picture">
	</div>

	<div class="next-header" id="next_header">
		<nav id="top_nav">
			<ul class="tab" id="ul_tab">
				<li><a href="./">ガチデッキ調整</a></li>
				<li><a class="left" href="casual">カジュアル</a></li>
				<li><a class="left" href="prepare">おまけ</a></li> 
			</ul>
		</nav>

		<br>

		<div class="center">
			<p class="top">
				ガチデッキ調整用掲示板
			</p>
			<p class="explanation">
				ガチデッキを調整したい方向けのルームマッチ掲示板です。<br>  
				大会前やランクマッチに挑む前の調整にどうぞ！
			</p>
			<p class="top">
				書き込み
			</p>
			<div class="template">
				<form id="form" action="" method="POST">
				<textarea name="data" class="textfield" rows="9" cols="40">
【フォーマット】
※どちらかを削除してください
・対戦形式1
・対戦形式2

【ルームID】
・</textarea>
			<input type="submit" class="submit" value="送信">
			</form>
			</div>

			<form>
				<input type="button" class="button" onclick="redirect()" value="最新の情報に更新する">
			</form>

			<script>
				function redirect(){
					sessionStorage.setItem('x',window.scrollX);
					sessionStorage.setItem('y',window.scrollY);
					location.href="./";
				}

				window.onload=function(){
					window.scroll(sessionStorage.getItem('x'),sessionStorage.getItem('y'));
					sessionStorage.removeItem('x');
					sessionStorage.removeItem('y');

					// console.log(document.documentElement.clientWidth);
					if(document.documentElement.clientWidth > 430){
						// ナビゲーションを上側に表示
						let nav = document.getElementById("bottom_nav");
						nav.remove();
						let nav2 = document.getElementById("top_nav");
						nav2.style.position = "sticky";
						nav2.style.position = "-webkit-sticky";
						nav2.style.top = "0";
						nav2.style.marginbottom = "0px";
					}else{
						// ナビゲーションを下側に表示
						let nav = document.getElementById("top_nav");
						nav.remove();
						let nav2 = document.getElementById("bottom_nav");
						nav2.style.position = "sticky";
						nav2.style.position = "-webkit-sticky";
						nav2.style.bottom = "0";
						nav2.style.marginbottom = "-18px";
					}
				}
			</script>

			<?php
				try{
						$dbh = new PDO('mysql:host=localhost;dbname=test','myosrspi','mark6popo!!443');
				}catch (PDOException $e){
						var_dump($e->getMessage());
						exit;
				}
				//echo "success!";
			?>
			<br>
			<div class="db_datas">
			<?php
				$count = (int)file_get_contents('counter.txt');
				$count++;
				file_put_contents('counter.txt',$count);

				if(!empty($_POST["data"])){
					$set = $dbh->prepare("insert into dmp (text,date) values(?,?)");
					$set->execute(array($_POST["data"],date("Y年m月d日 H:i")));
					header('Location: ./');
				}

				$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$sql = "select * from dmp";
				$stmt = $dbh->query($sql);
				//my test part
				$array_data = array(array("ここが最終ページ",""));
				while($result=$stmt->fetch()){
					array_unshift($array_data, array($result[0],$result[1]));
				}

				foreach($array_data as $value){
					echo '<div class="db_text">';
					// echo nl2br($value[0]);
					echo nl2br(htmlentities($value[0]));
					echo "<br><br>";
					echo '<p class="date_text">';
					// echo nl2br($value[1]);
					echo nl2br(htmlentities($value[1]));
					echo '</p>';
					echo '</div>';
				}
			?>
			</div>
		</div>
	</div>
	<!-- <footer> -->
	<nav id="bottom_nav">
		<ul class="tab">
			<li><a href="./">ガチデッキ調整</a></li>
			<li><a class="left" href="casual">カジュアル</a></li>
			<li><a class="left" href="prepare">おまけ</a></li> 
		</ul>
	</nav>
</body>
</html>

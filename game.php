<?php
  // $current_hitter = 0;
  if(!isset($_GET['move'])){
    $move = 0;
  }else{
    $move = $_GET['move'];
  }

  if($move == 0){
    $gamers = startGame($move);
  }else{
    $gamers = getCurrentState();
  }

  if($move == 0){
    $current_hitter = 0;
    $gamers = hitOpponent('0', $gamers);
    $gamers = hitOpponent('1', $gamers);
  }else if($_GET['move']%2 == 0){
    // четные ходы
    $current_hitter = 0;
    $gamers = hitOpponent($current_hitter, $gamers,false);
  }else{
    // не четные ходы
    $current_hitter = 1;

    $gamers = hitOpponent($current_hitter, $gamers,false);
  }

  function setNames($p1,$p2){
    return $names = array($p1, $p2);
  }

  function startGame($move){
    if (isset($_POST['player1']) && !empty($_POST['player1']) && !empty($_POST['player2']) && $move == 0) {
      $names = setNames($_POST['player1'],$_POST['player2']);
    }else{
      $names = setNames('Player 1', 'Player 2');
    }
      $player1 = [
        'name' => $names[0],
        'health' => '100',
        'attack_force' => 0,
        'defence_force' => 0
      ];
       $player2 = [
        'name' => $names[1],
        'health' => '100',
        'attack_force' => 0,
        'defence_force' => 0
      ];
    $gamers = [$player1, $player2];
    return $gamers;
  }

  function getCurrentState(){
      $gamers = json_decode($_POST['current_state'],true);
      return $gamers;
  }

  function hitOpponent($hitter, $gamers, $first = true){
    $attack_force = rand(0,100);
    $defence_force = rand (0,4);
    if($first == false){
      $gamers[1-$hitter]['attack_force'] = $attack_force;
      $gamers[1-$hitter]['defence_force'] = $defence_force;
      if(($gamers[1-$hitter]['attack_force'] + $gamers[$hitter]['attack_force'])%2 ==0){
        $gamers[$hitter]['health'] -= round($gamers[1-$hitter]['attack_force'] * (100-20*$gamers[$hitter]['defence_force'])/100);
          endGame($gamers);
      }
    }
    return $gamers;
  }



   function endGame($gamers){
	$name0 = $gamers[0]['name'];
	$name1 = $gamers[1]['name'];
    if($gamers[0]['health'] <= 0){
      header("Location:endgame.php?name=$name0");
    }if($gamers[1]['health'] <= 0){
      header("Location:endgame.php?name=$name1");
    }
    return false;
  }

 ?>
<html>
<head>
<title>GAME</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
      <?php
        // print_r($gamers);
       ?>
    <div class="container">
      <?php
        if ($move != 0){
       ?>
      <!-- <div class="well"> -->
        <div class="moves text-center"><h4>Move: <span class="text-danger"><?=$move?></span></h4></div>
      <!-- </div> -->
      <?php
      }
       ?>
      <div class="row">
      		<div class="col-sm-12 text-center">

      			<div style="background-color: pink; border-radius: 50px;">
      				<strong><?php
      						if(($gamers[0]['attack_force'] + $gamers[1]['attack_force'])%2 ==0 && $move != 0){
      							echo '<h3>' . '<span style="color:red;">' . "HIT" . '</span>' . '</h3>' ;
      						}elseif ($move != 0){
      							echo '<h3>' . '<span style="color:green;">' . "MISS" . '</span>' . '</h3>' ;
      						}
      					 	echo $gamers[0]['name']  . ' Attack: '  . $gamers[0]['attack_force'] . ", " . 'Defence: ' . $gamers[0]['defence_force'] . '<br>';
      						echo $gamers[1]['name'] . ' Attack: ' . $gamers[1]['attack_force'] . ", " . 'Defence: ' . $gamers[1]['defence_force'] . '<br>';
      					 ?>
      				</strong>
      			</div>
      		</div>
          <div class="col-sm-6 text-center">
            <div class="player_name text-center"><h3><?=$gamers[0]['name'] . ' '?><span class='text text-danger'style='transition: all 2s'><?=$gamers[0]['health']?>% </span></h3></div>
            <img src="img/zombie-live.gif" height="350">
            <form method="POST" action="game.php?move=<?=$move+1?>">
              <input  type="hidden" name='current_state' value='<?=json_encode($gamers)?>'>
              <input  <?php if($current_hitter == 1) echo "disabled";?> class='btn btn-danger btn-lg' type="submit" name="p1" value="HIT">
            </form>
          </div>
          <div class="col-sm-6 text-center">
              <div class="player_name text-center"><h3><?=$gamers[1]['name'] . ' ' ?><span class='text text-danger' style='transition: all 2s'><?=$gamers[1]['health']?>%</span></h3></div>
              <img src="img/girl-walking.gif" height="350">
              <form method="POST" action="game.php?move=<?=$move+1?>">
                <input  type="hidden" name='current_state' value='<?=json_encode($gamers)?>'>
                <input <?php if($current_hitter == 0) echo "disabled";?> class='btn btn-danger btn-lg'type="submit" name="p2" value="HIT">
            </form>
         </div>
      </div>
    </div>
  </div>
</body>
</html>

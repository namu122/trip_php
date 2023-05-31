<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>旅行先リスト</title>
    </head>

    <?php
    $obj=[
        ["id"=>"1","date"=>"2022-8-22","location"=>"金沢","check"=>"2022-11-1"],
        ["id"=>"2","date"=>"2022-9-16","location"=>"草津","check"=>"2022-11-3"]
    ];
    $jsonURL="1J21F162.json";
    if(file_exists($jsonURL)){
    $json=file_get_contents($jsonURL);
    $json=mb_convert_encoding($json,"UTF8","ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN");
    $obj=json_decode($json,true);
  }else{
    echo "データがありません";
  }



  if(!empty($_POST["create"])){

    //登録時に、すでに、同じidのものがあれば削除しておく
    foreach($obj as $key=>$val){
//         if($val["id"]==$obj["id"]){        //ここの、削除したい項目の指定方法と削除の処理の方法がわかりません。
      if($val["id"]==$_POST["id"]){        //ここの、削除したい項目の指定方法と削除の処理の方法がわかりません。
        //unset($val["id"]);
       unset($obj[$key]);
       $obj_json = json_encode($obj);//new
       file_put_contents("1J21F162.json" , $obj_json);//new
     }
   }



      array_push($obj,$_POST);
      $obj_json = json_encode($obj);//new
      file_put_contents("1J21F162.json" , $obj_json);//new


  }elseif(!empty($_POST["edit"])){
      //edit no shori

      $edit=$_POST;

  }elseif(!empty($_POST["eliminate"])){
       foreach($obj as $key=>$val){



//         if($val["id"]==$obj["id"]){        //ここの、削除したい項目の指定方法と削除の処理の方法がわかりません。
          if($val["id"]==$_POST["id"]){        //ここの、削除したい項目の指定方法と削除の処理の方法がわかりません。
            //unset($val["id"]);
           unset($obj[$key]);
           $obj_json = json_encode($obj);//new
           file_put_contents("1J21F162.json" , $obj_json);//new
         }
       }
  }


     ?>

<form action="" method="post">
        <section class="id">
            <label for="id">id</label>
            <input type="number" name="id" id="id" value="<?=$edit["id"]; ?>">
        </section>
        <section class="date">
          <label for="date">日程</label>
          <input type="date" name="date" id="date">
        </section>
        <section class="location">
          <label for="location">location</label>
          <input type="location" name="location" id="location">
        </section>
        <section class="check">
          <label for="check">check</label>
          <input type="date" name="check" id="check">
        </section>
        <section class="submit">
          <input type="submit" value="登録" name="create">
        </section>
    </form>

<table>
         <tr>
             <th>ID</th>
             <th>日程</th>
             <th>場所</th>
             <th>確認日</th>
     </tr>

     <?php foreach($obj as $key => $val):
       $x=$val["id"];
     ?>
       <tr>
         <td><?=$val["id"]; ?></td>
         <td><?=$val["date"]; ?></td>
         <td><?=$val["location"]; ?></td>
         <td><?=$val["check"]; ?></td>
         <td><form method="post"><input type="hidden" value=<?=$val["id"]; ?> name="id">
         <input type="hidden" value=<?=$val["date"]; ?> name="date">
         <input type="hidden" value=<?=$val["location"]; ?> name="location">
         <input type="submit" value=編集 name="edit"></form></td>
         <td><form method="post"><input type="hidden" value=<?=$val["id"]; ?> name="id"><input type="submit" value=削除 name="eliminate"></form></td>
       </tr>
     <?php endforeach; ?>
     </table>
     <?php
        if($_SERVER["REQUEST_METHOD"]==="POST"){
          if(isset($_POST["edit".$val["id"]])){

          }elseif(isset($_POST["eliminate".$val["id"]])){
           $result=array_search($val["id"],$obj);
           print_r($result);
           exit();
          }
        }
      ?>
</html>

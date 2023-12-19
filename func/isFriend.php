<?php
    function Isfriend($userID,$friendID){
        include("./proc/conexion.php");
        $sqlFriend="SELECT id_amigo FROM amigos WHERE (id_user = ? OR id_user = ?) AND (id_user_amigo = ? OR id_user_amigo = ?)";
        $stmt1 = mysqli_prepare($conn, $sqlFriend);
        mysqli_stmt_bind_param($stmt1, "iiii", $userID,$friendID,$userID,$friendID);
        mysqli_stmt_execute($stmt1);
        $res = mysqli_stmt_get_result($stmt1);
        if(mysqli_num_rows($res)>0){
            return true;
        }else{
            return false;
        }
    }
?>
<?php
// test
class testpoint {
    private $error; // エラー情報を保持するプロパティ
    private $db; // データベース接続を保持するプロパティ

    function __construct($db) {
        $this->db = $db;
        $this->error = []; // 初期化
    }

    public function role_select() {
        //$_SESSION["id"] = 10;
        // $this->db が null でないことを確認
        if ($this->db !== null) { 
            if (isset($_SESSION["user_id"])) {
                $sql = "SELECT sender_id,receiver_id,messagetext,sent_time FROM line_message WHERE receiver_id = ";
                $id = $_SESSION["user_id"];
                $sql = $sql.$id;
                $stmt = $this->db->query($sql);
                $f = true;

                foreach($stmt as $record){
                    $f = false;
                    echo "メッセージ:" . $record[2] . "<br>";
                    echo "送信日:" . $record[3] . "<br><br>";
                }

                if ($f) {
                    echo "<p>メッセージはありません</p>";
                }
            } else {
                echo "ログインせい";
            }
        } else {
            echo "<p>エラー</p>";
        }
    }

    public function sessiontest() {
        // echo "role_id=".$_SESSION["role_id"]."<br>";
        // echo "select=".$_SESSION["select"]."<br>";
        // echo "admin_flag=".$_SESSION["admin_flag"]."<br>";
        // $c = floor($_SESSION["role_id"]/ 10);
        // echo "kore".$c;
        if (isset($_SESSION["user_id"])) {
            echo "ログインしております";
        } else {
            echo "ログインしてや";
        }
    }
}
?>
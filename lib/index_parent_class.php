<?php
// test
class index_parent_class {
    private $error; // エラー情報を保持するプロパティ
    private $db; // データベース接続を保持するプロパティ
    
    function __construct($db) {
        $this->db = $db;
        $this->error = []; // 初期化
    }

    function message($db) {
        $today = new DateTime('now');
        if (!empty($_POST['check'])) {
            $statement = $db->prepare("INSERT INTO line_message SET sender_id=?, receiver_id=?, messagetext=?, sent_time=?");
            $statement->execute(array($_SESSION["user_id"], $_POST['receiver'], $_POST['message'], $today->format('Y-m-d H:i:s')));
        }    

    }

    
    public function getFamilyUser() {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $family_id = $result['family_id'];

        $stmt = $this->db->prepare("SELECT * FROM user WHERE family_id = :family_id AND NOT user_id = :user_id AND role_id > 30");
        $stmt->bindParam(':family_id', $family_id);
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $record) {
            echo '<option value="';
            echo $record['user_id'];
            echo '">';
            echo $record['first_name'];
            echo "</option>";
        }
    }

    public function getChildSavings($i) {
        $stmt = $this->db->prepare("SELECT * FROM child_data WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $i);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) != 0){
            return $result[0];
        } else {
            return array(
                'savings'=>0,
                'have_points'=>0,
            );
        }
    }
    public function getChildAllowance($i) {
        $stmt = $this->db->prepare("SELECT * FROM allowance WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $i);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) != 0){
            return $result[0];
        } else {
            return array(
                'allowance_amount'=>0,
            );
        }
    }
    public function getBehavioral($i) {
        $stmt = $this->db->prepare("SELECT * FROM behavioral_goal WHERE behavioral_goal_user_id = :user_id");
        $stmt->bindParam(':user_id', $i);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) != 0){
            return $result[0];
        } else {
            return array(
                'behavioral_goal'=>'行動目標を設定してください',
                'reward_point'=>0,
                'behavioral_goal_deadline'=>'',
            );
        }
    }
    public function getPointNorma($i) {
        $stmt = $this->db->prepare("SELECT * FROM point_norma WHERE point_norma_user_id = :user_id");
        $stmt->bindParam(':user_id', $i);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) != 0){
            return $result[0];
        }else{
            return array(
                'point_norma_amount'=>0,
                'point_norma_deadline'=>'ポイントノルマが設定されていません',
            );
        }
    }

    public function getFamily() {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $family_id = $result['family_id'];

        $stmt = $this->db->prepare("SELECT * FROM goal WHERE family_id = :family_id order by goal_deadline desc");
        $stmt->bindParam(':family_id', $family_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMessageCount() {
        $stmt = $this->db->prepare("SELECT * FROM line_message WHERE sender_id = :user_id OR receiver_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return count($result);
    }

    public function getMessage($i) {
        $stmt = $this->db->prepare("SELECT * FROM line_message WHERE sender_id = :user_id OR receiver_id = :user_id order by sent_time desc");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $message = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $message[$i]['sender_id']);
        $stmt->execute();
        $sender = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $message[$i]['receiver_id']);
        $stmt->execute();
        $receiver = $stmt->fetch(PDO::FETCH_ASSOC);

        return array(
            'session_user' => $_SESSION["user_id"],
            'messagetext' => $message[$i]['messagetext'],
            'sent_time' => $message[$i]['sent_time'],
            'sender' => $sender['first_name'],
            'sender_id' => $sender['user_id'],
            'receiver' => $receiver['first_name'],
            'receiver_id' => $receiver['user_id'],
        );
    }

    public function getHelp($i) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $family_id = $result['family_id'];

        $stmt = $this->db->prepare("SELECT * FROM help WHERE family_id = :family_id");
        $stmt->bindParam(':family_id', $family_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $help_name = $result[$i]['help_name'];
    
        return $help_name;
    }

    public function getHelpCount() {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $family_id = $result['family_id'];

        $stmt = $this->db->prepare("SELECT * FROM help WHERE family_id = :family_id");
        $stmt->bindParam(':family_id', $family_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $help_count = count($result);
    
        return $help_count;
    }
    
    public function getHave_points() {
        $stmt = $this->db->prepare("SELECT have_points FROM child_data WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) != 0) {
            return $result[0]['have_points'];
        } else {
            return 0;
        }
    }

    public function getSavings() {
        $stmt = $this->db->prepare("SELECT * FROM child_data WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) != 0) {
            return $result[0]['savings'];
        } else {
            return 0;
        }
    }

    public function getGoalCount() {
        $stmt = $this->db->prepare("SELECT * FROM goal WHERE goal_user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return count($result);
    }

    public function getTarget_amount() {
        $stmt = $this->db->prepare("SELECT * FROM goal WHERE goal_user_id = :user_id order by goal_deadline asc");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($result as $deadline) {
            $date01 = new DateTime('now');
            $date02 = new DateTime($deadline['goal_deadline']);

            if ($date01 <= $date02) {
                return $deadline['target_amount'];
            }
        }
    }

    public function getGoal_deadline() {
        $stmt = $this->db->prepare("SELECT * FROM goal WHERE goal_user_id = :user_id order by goal_deadline asc");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $deadline) {
            $date01 = new DateTime('now');
            $date02 = new DateTime($deadline['goal_deadline']);

            if ($date01 <= $date02) {
                return $deadline['goal_deadline'];
            }
        }
    }

    public function getGoal_detail() {
        $stmt = $this->db->prepare("SELECT * FROM goal WHERE goal_user_id = :user_id order by goal_deadline asc");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $deadline) {
            $date01 = new DateTime('now');
            $date02 = new DateTime($deadline['goal_deadline']);

            if ($date01 <= $date02) {
                return $deadline['goal_detail'];
            }
        }
    }

    public function getRequired_point() {
        $stmt = $this->db->prepare("SELECT * FROM goal WHERE goal_user_id = :goal_user_id order by goal_deadline asc");
        $stmt->bindParam(':goal_user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $deadline) {
            $date01 = new DateTime('now');
            $date02 = new DateTime($deadline['goal_deadline']);
            
            if ($date01 <= $date02) {
                $date01 = new DateTime('now');
                $date02 = new DateTime($deadline['goal_deadline']);
                $diff = date_diff($date01, $date02);
                
                $target_amount = $deadline['target_amount'];
                
                $stmt = $this->db->prepare("SELECT have_points FROM child_data WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) != 0) {
                    $have_points = $result[0]['have_points'];
                } else {
                    $have_points = 0;
                }

                $stmt = $this->db->prepare("SELECT savings FROM child_data WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) != 0) {
                    $savings = $result[0]['savings'];
                } else {
                    $savings = 0;
                }
                
                $stmt = $this->db->prepare("SELECT allowance_amount FROM allowance WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $allowance_amount = $result['allowance_amount'];
                
                $answer = $target_amount - $have_points - $savings - $allowance_amount * $diff->m;
                
                if ($answer >= 0) {
                    return $answer;
                } else {
                    return 0;
                }
            }
        }
    }

    public function getOnerequired_point() {
        $stmt = $this->db->prepare("SELECT * FROM goal WHERE goal_user_id = :goal_user_id order by goal_deadline asc");
        $stmt->bindParam(':goal_user_id', $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $deadline) {
            $date01 = new DateTime('now');
            $date02 = new DateTime($deadline['goal_deadline']);
            
            if ($date01 <= $date02) {
                $date01 = new DateTime('now');
                $date02 = new DateTime($deadline['goal_deadline']);
                $diff = date_diff($date01, $date02);
                
                $diff2 = $date01->diff($date02);
                
                $target_amount = $deadline['target_amount'];
                
                $stmt = $this->db->prepare("SELECT have_points FROM child_data WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) != 0) {
                    $have_points = $result[0]['have_points'];
                } else {
                    $have_points = 0;
                }
                
                $stmt = $this->db->prepare("SELECT savings FROM child_data WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) != 0) {
                    $savings = $result[0]['savings'];
                } else {
                    $savings = 0;
                }
                
                $stmt = $this->db->prepare("SELECT allowance_amount FROM allowance WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $allowance_amount = $result['allowance_amount'];
                
                $answer = ceil(($target_amount - $have_points - $savings - $allowance_amount * $diff->m) / $diff2->format('%a'));
                
                if ($answer >= 0) {
                    return $answer;
                } else {
                    return 0;
                }
            }
        }
    }
    public function againgoalPassed($family_id)
    {
        $current_date = date("Y-m-d");
        $query = "SELECT COUNT(*) AS count FROM goal WHERE family_id = :family_id AND goal_deadline < :current_date";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':family_id', $family_id);
        $stmt->bindParam(':current_date', $current_date);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }


    public function checkPointNormaDeadlinePassed()
    {
        $current_date = date("Y-m-d");
        $query = "SELECT COUNT(*) AS count FROM point_norma WHERE point_norma_deadline < '$current_date'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    public function behavioralNormaDeadlinePassed()
    {
        $current_date = date("Y-m-d");
        $query = "SELECT COUNT(*) AS count FROM behavioral_goal WHERE behavioral_goal_deadline < '$current_date'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
}
?>
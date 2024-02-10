<!-- トップページ画面親用 -->

<!-- ヘッダー -->
<?php
$page_title = "大人用トップページ";
$stylesheet_name = "index_parent.css";
include("./include/header.php");
?>

<?php
// testpointクラスのインスタンスを作成
require($absolute_path."lib/testpoint_class.php");
$testpoint = new testpoint($db);

require($absolute_path."lib/index_parent_class.php");
$index_parent_class = new index_parent_class($db);

//family_addでのsessionがあれば完了の通知出す
if (isset($_SESSION['family_success']) && $_SESSION['family_success']) {
    echo '<script>alert("' . $_SESSION['family_count'] . '人の登録が完了しました。");</script>';
    unset($_SESSION['family_success'], $_SESSION['family_count']);
}

echo '<script>';
foreach ($index_parent_class->getFamily() as $child) {
    $goal_deadline = $child['goal_deadline'];
    if ($index_parent_class->isDeadlinePassed($goal_deadline)) {
        echo 'alert("子供の目標の期限が過ぎています！");';
        echo 'window.location.href = "./goal/again_goal.php";'; 
        break;
    }
}
echo '</script>';

?>
<ul>
    <li><a href="<?php echo $absolute_path; ?>src/app/goal/goal.php"><img src="">購入目標</a></li>
    <li><a href="<?php echo $absolute_path; ?>src/app/point_norma/setting_norma.php"><img src="">ポイントノルマ</a></li>
    <li><a href="<?php echo $absolute_path; ?>src/app/behavioral_goal/setting_behavioral.php"><img src="">行動目標</a></li>
</ul>


<!-- ナビゲーションバー -->
<?php include_once("./include/nav_bar.php") ?>

<main>
    <!-- ロゴ -->
    <header class="position-relative h-25" style="padding-top: 4rem;">
        <img class="d-block mx-auto py-3" src="<?php echo $absolute_path; ?>static/assets/logo.png" height="120">
    </header>

    <section class="position-relative h-75">
        <div class="container px-4">
            <div class="row row-cols-1 row-cols-md-3 gx-3 gy-5 justify-content-around">
                <div class="col col-md-2">
                    <div class="row row-cols-2 row-cols-md-1 gy-4 justify-content-around">
                    </div>
                </div>
            </div>
        </div>

        <select id="user_select">
            <option value=""></option>
            <?php $index_parent_class->getFamilyUser(); ?>
        </select>
        <br>
        目標：<p id="goal_detail"></p>
        期限：<p id="goal_deadline"></p>
        値段：<p id="target_amount"></p>
        貯金：<p id="savings"></p>

    </section>
</main>

<script>
    let select = document.getElementById('user_select');
    let goal_detail = '';
    let goal_deadline = '';
    let target_amount = '';
    let savings = '';
    let points = '';
    let have;
    let day;
    let dayPoint;
    let allowance_amount;
    select.addEventListener('change', (e) => {
        let selected_value = document.getElementById('user_select').value;
        <?php for($i=0;$i<count($index_parent_class->getFamily());$i++){ ?>
            if(selected_value == <?php echo $index_parent_class->getFamily()[$i]['user_id'] ?>){
                <?php 
                    $today = new DateTime('now');
                    $deadline = new DateTime($index_parent_class->getFamily()[$i]['goal_deadline']);
                ?>
                <?php if($today->format('Y-m-d') <= $deadline->format('Y-m-d')){ ?>
                     goal_detail = '<?php echo $index_parent_class->getFamily()[$i]['goal_detail'];?>';
                     goal_deadline = '<?php echo $index_parent_class->getFamily()[$i]['goal_deadline'];?>';
                     target_amount = '<?php echo $index_parent_class->getFamily()[$i]['target_amount'];?>';
                     savings = <?php echo $index_parent_class->getChildSavings($index_parent_class->getFamily()[$i]['user_id'])['savings'];?>;
                     points = <?php echo $index_parent_class->getChildSavings($index_parent_class->getFamily()[$i]['user_id'])['have_points'];?>;
                     have = savings + points;
                     allowance_amount = <?php echo $index_parent_class->getChildAllowance($index_parent_class->getFamily()[$i]['user_id'])['allowance_amount']; ?>;
                     day = <?php echo $today->diff($deadline)->format('%a'); ?>;
                     if(target_amount - have - allowance_amount * <?php echo date_diff($today, $deadline)->m; ?> >= 0){
                         if(day != 0){
                             dayPoint = (target_amount - have - allowance_amount * <?php echo date_diff($today, $deadline)->m; ?>) / day;
                        } else {
                            dayPoint = target_amount - have - allowance_amount * <?php echo date_diff($today, $deadline)->m; ?>;
                        }
                    } else {
                        dayPoint = 0;
                    }

                <?php } ?>
            }
        <?php } ?>
        document.getElementById('goal_detail').innerHTML = goal_detail;
        document.getElementById('goal_deadline').innerHTML = goal_deadline;
        document.getElementById('target_amount').innerHTML = target_amount;
        document.getElementById('savings').innerHTML = savings;
        document.getElementById('points').innerHTML = points;
        document.getElementById('have').innerHTML = have;
        document.getElementById('dayPoint').innerHTML = dayPoint;
    });
</script>
<!-- ナビゲーションバー -->
<?php include_once("./include/bottom_nav.php") ?>
<!-- フッター -->
<?php include_once("./include/footer.php"); ?>
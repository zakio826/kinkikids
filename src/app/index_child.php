<!-- トップページ画面子用 -->

<!-- ヘッダー -->
<?php
$page_title = "子供用トップページ";
$stylesheet_name = "index_child.css";
include("./include/header.php");
?>

<?php

// testpointクラスのインスタンスを作成
require($absolute_path."lib/testpoint_class.php");
$testpoint = new testpoint($db);


require($absolute_path."lib/index_child_class.php");
$index_child_class = new index_child_class($db);
$have_points = $index_child_class->getHave_points();
$savings = $index_child_class->getSavings();
$have_money = $have_points+$savings;
$goal_count = $index_child_class->getGoalCount();
$help_count = $index_child_class->getHelpCount();
$message_count = $index_child_class->getMessageCount();

$index_child_class->message($db);
?>


<!-- ナビゲーションバー -->
<?php include_once("./include/nav_bar.php") ?>

<main>
    <!-- ロゴ -->
    <header class="position-relative h-25" style="padding-top: 4rem;">
        <img class="d-block mx-auto py-3 index_child_logo" src="<?php echo $absolute_path; ?>static/assets/logo.png" height="120">
    </header>
    
    <section class="position-relative h-75">
    <a href="<?php echo $absolute_path; ?>src/app/goal/goal_list.php">目標一覧</a>

        <div class="index_child_mokuhyoucss1">
            <div class="index_child_mokuhyoucss2">
            <?php if ($goal_count != 0) : ?>
                <a href="./goal/goal_detail.php">ちかぢかせまっているもくひょう<br>
                <span>
                    <?php echo htmlspecialchars($index_child_class->getGoal_detail()); ?><br>
                    <?php echo htmlspecialchars($index_child_class->getGoal_deadline()); ?> 
                    <?php echo htmlspecialchars($index_child_class->getTarget_amount()); ?> 円
                <span>
                </a>
            <?php else : ?>
                <span><p>目標がないので設定してください</p></span>
            <?php endif; ?>
            </div>
        </div>
        <hr class="index_child_hr">
        <div class="index_child_mokuhyoucss3">
            <div class="index_child_mokuhyoucss4">
            <p class="row">
                    <span class="col-6">
                        しょじきん:<span class="px-2"><?php echo htmlspecialchars($savings); ?></span>えん
                    </span>
                    <span class="col-6">
                        てもち:<span class="px-2"><?php echo htmlspecialchars($have_points); ?></span>ポイント
                    </span>
                </p>

            <?php if($goal_count != 0) : ?>
                <p>
                    きょうかせぐポイント:
                    <span class="px-2">
                        <?php echo htmlspecialchars($index_child_class->getOnerequired_point()); ?>
                    </span>
                    ポイント
                </p>
            <?php else : ?>
                <p class="index_child_moji">
                    <br>目標がないので設定してください
                </p>
            <?php endif; ?>
            </div>
        </div>

        <hr>


        <div>
            <ul>
                <li><a href="<?php echo $absolute_path; ?>src/app/goal/goal.php"><img src="">購入目標</a></li>
                <li><a href="<?php echo $absolute_path; ?>src/app/point_norma/setting_norma.php"><img src="">ポイントノルマ</a></li>
                <li><a href="<?php echo $absolute_path; ?>src/app/behavioral_goal/setting_behavioral.php"><img src="">行動目標</a></li>
            </ul>
        </div>

        <hr>


            </div>
        </div>
        <hr class="index_child_hr">
        <br>

        <!-- <hr class="index_child_hr"> -->
        <div class="index_child_messagecss1">
            <div class="index_child_messagecss2">
            <div class="index_child_messagecss3">

            <!-- <span>
                <p>メッセージ</p>
            </span> -->
            <p>
                <img src="<?php echo $absolute_path; ?>static/assets/messageC.png" height=40 alt="メッセージ">
            </p>
            <select id="user_select">
                <option value=""></option>
                <?php $index_child_class->getFamilyUser(); ?>
            </select>

           
            <div style="width: 100%; height: 100px; overflow-y: scroll; border: 1px #999999 solid;">
               <p class="mb-3" id="order-string"></p>
            </div> 

            <div style="width: 100%; height: 100px; overflow-y: scroll; border: 1px #999999 solid;">
                <?php if ($message_count != 0) : ?>
                    <?php for ($i = 0; $i < $message_count; $i++) : ?>
                        <?php echo htmlspecialchars($index_child_class->getMessage($i)['sender']); ?>
                        ➡
                        <?php echo htmlspecialchars($index_child_class->getMessage($i)['receiver']); ?>
                        
                        <p>
                        <?php echo htmlspecialchars($index_child_class->getMessage($i)['messagetext']); ?> 
                        <?php echo htmlspecialchars($index_child_class->getMessage($i)['sent_time']); ?> 
                        </p>

                        <hr>

                    <?php endfor; ?>
                <?php else : ?>
                    <p>メッセージがありません</p>
                <?php endif; ?>
            </div>

            <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
                <p>誰に送るか</p>
                <select name="receiver" required>
                    <option value=""></option>
                    <?php $index_child_class->getFamilyUser(); ?>
                </select>
                <input type="text" name="message" required>
                <button type="submit">返信</button>
            </form>
                
            </div>
            </div>
        </div>
    </section>
</main>

<!-- ナビゲーションバー -->
<?php include_once("./include/bottom_nav.php") ?>

<script>    
    let select = document.getElementById('user_select');
    let count = <?php echo $message_count; ?>;

    select.addEventListener('change', (e) => {
        let selected_value = document.getElementById('user_select').value;
        let message = [];

        let xxx1 = null;
        let xxx2 = null;
        let xxx3 = null;
        let xxx4 = null;
        let xxx5 = null;
        
        <?php for ($i = 0; $i < $message_count; $i++) : ?>
            xxx1 = <?php echo htmlspecialchars($index_child_class->getMessage($i)['receiver_id']); ?>;
            xxx2 = <?php echo htmlspecialchars($index_child_class->getMessage($i)['session_user']); ?>;
            xxx3 = <?php echo htmlspecialchars($index_child_class->getMessage($i)['sender_id']); ?>;
            xxx4 = '<?php echo htmlspecialchars($index_child_class->getMessage($i)['messagetext']); ?>';
            xxx5 = '<?php echo htmlspecialchars($index_child_class->getMessage($i)['sender']); ?>';

            if (selected_value == xxx1 && xxx2 == xxx3 || selected_value == xxx3 && xxx2 == xxx1) {
                if (selected_value == xxx1 && xxx2 == xxx3) message.push('自分：' + xxx4);
                else message.push(xxx5 + '：' + xxx4);
            }
        <?php endfor; ?>

        let str = message.join('<br>');
        document.getElementById('order-string').innerHTML = str;
    });
</script>

<!-- フッター -->
<?php include_once("./include/footer.php"); ?>

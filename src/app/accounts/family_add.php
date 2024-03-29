<!-- ユーザー登録ページ -->

<!-- ヘッダー -->
<?php
$page_title = "アカウント作成";
$stylesheet_name = "family_add.css";
require_once("../include/header.php");
?>

<?php
// family_addクラスのインスタンスを作成
require($absolute_path."lib/family_add_class.php");
$family_add = new family_add($db);

 if (!isset($_SESSION["admin_flag"]) || $_SESSION["admin_flag"] !== 1) {
     header("Location: ../index.php");
     exit;
 }

if (isset($_SESSION['join'])) {
    $savedData = $_SESSION['join'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $family_add->__construct($db);
}
?>

<!-- ナビゲーションバー -->
<?php include_once("../include/nav_bar.php") ?>

<main>
    <div class="content">
        <form action="" method="POST">
            <h1>アカウント<ruby>追加<rt>ついか</rt></ruby></h1>
            <p class="mb-3"><ruby>当<rt>とう</rt></ruby>サービスをご<ruby>利用<rt>りよう</rt></ruby>するために、<br><ruby>次<rt>つぎ</rt></ruby>のフォームに<ruby>必要事項<rt>ひつようじこう</rt></ruby>をご<ruby>記入<rt>きにゅう</rt></ruby>ください。</p>
            <div class="control"><button type="submit" class="btn"><ruby>確認<rt>かくにん</rt></ruby>する</button></div>
            <div class="btn-p"><button type="button" id="addUser" >＋</button></div>
            <div class="scrollable-container">
                <?php
                    // 追加フォームに対応するためのループ
                    $userCount = isset($savedData['username']) ? count($savedData['username']) : 0;
                    for ($i = 0; $i < max(1, $userCount); $i++) {
                ?>
                <div id="userFormsContainer">
                    <div id="userForm" class="control">
                        <!-- ユーザー情報の入力フォーム -->
                        <div class="control">
                            <label for="username">ユーザー<ruby>名<rt>めい</rt></ruby></label>
                            <input type="text" name="username[]" maxlength="20"><br> required
                            <?php if(isset($errors['username'][0])){
                                    $family_add->username_error($errors['username'][0]);
                            } ?>
                            <p class="note"><b>※半角英数字20文字以内<br>
                                               ※特殊文字（. - _）のみ使用可能</b></p>
                        </div>
                        
                        <div class="control">
                            <label for="password">パスワード</label>
                            <input type="password" name="password[]" minlength="8" maxlength="100" placeholder="※半角英数字で8文字以上入力してください" required>
                        </div>

                        <div class="control">
                            <label for="last_name"><ruby>名字<rt>みょうじ</rt></ruby></label>
                            <input type="text" name="last_name[]" required
                            value="<?php echo (isset($savedData['last_name'][$i]) && !empty($savedData['last_name'][$i])) ? $savedData['last_name'][$i] : ''; ?>">
                        </div>

                        <div class="control">
                            <label for="first_name"><ruby>名前<rt>なまえ</rt></ruby></label>
                            <input type="text" name="first_name[]" required
                            value="<?php echo (isset($savedData['first_name'][$i]) && !empty($savedData['first_name'][$i])) ? $savedData['first_name'][$i] : ''; ?>">
                        </div>

                        <div class="control">
                            <label for="birthday"><ruby>誕生日<rt>たんじょうび</rt></ruby></label>
                            <input type="date" name="birthday[]"
                            value="<?php echo (isset($savedData['birthday'][$i]) && !empty($savedData['birthday'][$i])) ? $savedData['birthday'][$i] : ''; ?>">
                        </div>

                        <div class="control">
                            <label for="gender_id"><ruby>性別<rt>せいべつ</rt></ruby></label>
                            <select name="gender_id[]">
                                <option value="1" <?php echo (isset($savedData['gender_id'][$i]) && $savedData['gender_id'][$i] == 1) ? 'selected' : ''; ?>>女性</option>
                                <option value="2" <?php echo (isset($savedData['gender_id'][$i]) && $savedData['gender_id'][$i] == 2) ? 'selected' : ''; ?>>男性</option>
                                <option value="3" <?php echo (isset($savedData['gender_id'][$i]) && $savedData['gender_id'][$i] == 3) ? 'selected' : ''; ?>>その他</option>
                            </select>
                        </div>

                        <div class="control">
                            <label for="role_id"><ruby>役割<rt>やくわり<rt><ruby></label>
                            <select name="role_id[]" class="roleSelect" onchange="toggleSavingsField(this)">
                                <?php $family_add->role_select(); ?>
                            </select>
                        </div>

                        <div class="control" style="display: none;">
                            <label for="savings"><ruby>貯蓄<rt>ちょちく</rt></ruby></label>
                            <input class="mb-3 savings-input" type="number" name="savings[]" min="0" max="9999999999" required
                            value="<?php echo (isset($savedData['savings'][$i]) && !empty($savedData['savings'][$i])) ? $savedData['savings'][$i] : '0'; ?>">

                            <label for="allowances">お<ruby>小遣<rt>こづか</rt></ruby>い<ruby>金額<rt>きんがく</rt></ruby></label>
                            <input class="allowance-input" type="number" name="allowances[]" min="0" max="9999999999" required
                            value="<?php echo (isset($savedData['allowances'][$i]) && !empty($savedData['allowances'][$i])) ? $savedData['allowances'][$i] : '0'; ?>">

                            <label for="payments"><ruby>受取日<rt>うけとりび</rt></ruby></label>
                            <input class="payment-input" type="number" name="payments[]" min="0" max="31" required
                            value="<?php echo (isset($savedData['payments'][$i]) && !empty($savedData['payments'][$i])) ? $savedData['payments'][$i] : '0'; ?>">
                        </div>

                        <div class="control">
                            <label for="admin_flag"><ruby>管理者<rt>かんりしゃ</rt></ruby></label>
                            <input type="checkbox" name="admin_flag[]">
                        </div>
                        <?php if ($i > 0) { // 2番目以降のフォームにはマイナスボタンを表示 ?>
                            <button type="button" class="removeUser">－</button>
                        <?php } ?>
                    </div>
                <?php
                    }
                ?>
                </div>

                
            </div>
        </form>
    </div>
</main>

<!-- ナビゲーションバー -->
<?php include_once("../include/bottom_nav.php") ?>

<!-- JavaScript -->
<script src="<?php echo $absolute_path; ?>static/js/family_add.js"></script>

<!-- フッター -->
<?php require_once("../include/footer.php"); ?>
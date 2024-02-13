//bodyタグ取得・全画面表示のときに疑似要素でレイヤーをかけるため
const body = document.getElementById("body");
//支出カテゴリーdiv要素取得
const spendingCategoryBox = document.getElementById("spendingCategoryBox");
//支出カテゴリーselect要素取得
const spendingCategory = document.getElementById("spendingCategory");
//収入カテゴリーdiv要素取得
const incomeCategoryBox = document.getElementById("incomeCategoryBox");
//収入カテゴリーselect要素取得
const incomeCategory = document.getElementById("incomeCategory");
//支払い方法div要素取得
const paymentMethodBox = document.getElementById("paymentMethodBox");
//支払い方法select要素取得
const paymentMethod = document.getElementById("paymentMethod");
//クレジットカードdiv要素取得
const creditSelectBox = document.getElementById("creditSelectBox");
//スマホ決済div要素取得
const qrSelectBox = document.getElementById("qrSelectBox");
//操作完了ボックスsection要素取得
const doneOperateBox = document.getElementById("doneOperateBox");
//操作完了ボックスpタグ要素取得
const doneText = document.getElementById("doneText");
const detailModalBox = document.getElementById("detailModalBox");

//スマホデータ表示切り替えinput
const toggleStyle = document.getElementById("toggleStyle");
//スマホデータ切り替え要素
const groupView = document.getElementById("groupView");
const allView = document.getElementById("allView");

const household = document.getElementById("household");
//家計簿切り替え要素
const input_data = document.getElementById("input_data");
const calendar = document.getElementById("calendar");
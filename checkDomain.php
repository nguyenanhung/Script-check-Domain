<?php
error_reporting(E_ALL ^ E_NOTICE);
include 'apiDomain.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Check Domain - Powered F8VN Labs</title>
<meta name="description" content="WHOIS lookup service.">
<meta name="keywords" content="whois,lookup,domain">
<?php include 'css.php'; ?>
</head>
<body>
<div class="container">
<table style="width:100%; border-collapse:collapse;">
<tr>
<td style="text-align:left; vertical-align:middle; padding:0px;"><a href="<?php echo htmlspecialchars($header_title_url) ?>" id="title_link"><b><?php echo $header_title ?></b></a></td>
<td style="text-align:right; vertical-align:middle; padding:0px;"><div style="width:468px"></div></td>
</tr>
</table>
<br>
<hr>
<br>
<?php
if (isset($errors) && count($errors)) {
	foreach ($errors as $value) {
		echo "<span class=\"error_messages\"><b>" . stripslashes($value) . "</b></span><br>";
	}
	echo "<br>";
}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
<div id="lookup_form">
<input type="text" placeholder="Nhập tên miền cần tra cứu" name="domain" value="<?php if(isset($_POST['domain'])){echo stripslashes(htmlspecialchars($_POST['domain']));} ?>">
<select name="extension">
<?php
foreach ($extensions_array as $value) {
	if ((isset($_POST['extension']) && $_POST['extension'] == $value) || (!isset($_POST['extension']) && $value == $default_extension)) {
		echo "<option value=\"$value\" selected>{$value}</option>\n";
	} else {
		echo "<option value=\"$value\">{$value}</option>\n";
	}
}
?>
</select>
<input type="submit" value="Check Domain">
</div>
</form>
<?php
if (isset($domain_registered_message) && !empty($domain_registered_message)) {
	echo "<br>" . $domain_registered_message . "<br><br>";
}
if (isset($response) && !empty($response)) {
	echo "<div class=\"response_display\">Kết quả trả về từ WHOIS server ($whois_server):<br><br>" . str_replace("\n", "<br>", $response) . "</div>";
}
if($_SERVER['REQUEST_METHOD'] == "GET")
{
?>
<br />Hệ thống kiểm tra sự tồn tại của tên miền dựa trên 1 số API server được cung cấp sẵn. Script này hoàn toàn miễn phí, các bạn có thể download nó từ Github tại đây: <a href="https://github.com/nguyenanhung/Script-check-Domain" target="_blank" title="Script check Domain">Script check Domain</a>
<?php
}
?>
<br><br>Powered by <a href="http://blog.nguyenanhung.com" style="color:#0000ff">F8VN Labs</a>
</div>
</body>
</html>
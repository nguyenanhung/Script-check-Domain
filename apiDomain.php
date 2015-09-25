<?php
$connection_timeout             = 5;
$default_extension              = "";
$header_title                   = "Kiểm tra tên miền - Powered by F8VN Labs";
$header_title_url               = $_SERVER["PHP_SELF"];
$internal_style_sheet           = 1;
$external_style_sheet           = 0;
$external_style_sheet_location  = "/style.css";
$body_font_family               = "verdana,arial,sans-serif";
$body_font_size                 = "80%";
$body_background                = "#d4d4d4";
$body_color                     = "#000000";
$body_padding                   = "0";
$body_border                    = "0";
$body_margin                    = "20px";
$hr_background                  = "#d4d4d4";
$hr_color                       = "#d4d4d4";
$link_text_decoration           = "underline";
$link_color                     = "#0000ff";
$link_background                = "#ffffff";
$link_hover_text_decoration     = "underline";
$link_hover_color               = "#0000ff";
$link_hover_background          = "#ffffff";
$link_visited_text_decoration   = "underline";
$link_visited_color             = "#0000ff";
$link_visited_background        = "#ffffff";
$link_active_text_decoration    = "underline";
$link_active_color              = "#0000ff";
$link_active_background         = "#ffffff";
$container_background           = "#ffffff";
$title_link_font_size           = "25px";
$title_link_color               = "#000000";
$title_link_text_decoration     = "none";
$title_link_background          = "#ffffff";
$error_messages_color           = "#ff0000";
$form_background                = "#f2f2f2";
$form_border                    = "#d4d4d4";
$response_display_background    = "#f2f2f2";
$domain_available_message_color = "#009900";
// Liệt kê danh sách API
$supported_extensions           = array(
	".com" => array(
		"whois_server" => "whois.verisign-grs.com"
	),
	".net" => array(
		"whois_server" => "whois.verisign-grs.com"
	),
	".org" => array(
		"whois_server" => "whois.publicinterestregistry.net"
	),
	".info" => array(
		"whois_server" => "whois.afilias.info"
	),
	".biz" => array(
		"whois_server" => "whois.biz"
	),
	".co.uk" => array(
		"whois_server" => "whois.nic.uk"
	),
	".ca" => array(
		"whois_server" => "whois.cira.ca"
	),
	".com.au" => array(
		"whois_server" => "whois.audns.net.au"
	)
);
$extensions_array               = array_keys($supported_extensions);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	foreach ($_POST as $key => $value) {
		$_POST[$key] = strtolower(trim($value));
	}
	$errors = array();
	if (!isset($_POST['domain']) || empty($_POST['domain']) || !isset($_POST['extension']) || empty($_POST['extension'])) {
		$errors[] = "Please enter a domain name.";
	}
	if (isset($_POST['domain']) && !empty($_POST['domain'])) {
		$_POST['domain'] = str_replace(" ", "", $_POST['domain']);
		if (strlen($_POST['domain']) > 63) {
			$errors[] = "Domain is too long.  Max 63 characters.";
		}
		if (!preg_match('/^[0-9a-zA-Z-]+$/i', $_POST['domain'])) {
			$errors[] = "Domain may only contain numbers, letters or hyphens.";
		}
		if (substr(stripslashes($_POST['domain']), 0, 1) == "-" || substr(stripslashes($_POST['domain']), -1) == "-") {
			$errors[] = "Domain may not begin or end with a hyphen.";
		}
	}
	if (!in_array($_POST['extension'], $extensions_array)) {
		$errors[] = "Domain extension is not supported.";
	}
	if (!count($errors)) {
		$domain                = $_POST['domain'];
		$extension             = $_POST['extension'];
		// Check server Whois
		$whois_servers         = array(
			"whois.afilias.info" => array(
				"port" => "43",
				"query_begin" => "",
				"query_end" => "\r\n",
				"redirect" => "0",
				"redirect_string" => "",
				"no_match_string" => "NOT FOUND",
				"match_string" => "Domain Name:",
				"encoding" => "UTF-8"
			),
			"whois.audns.net.au" => array(
				"port" => "43",
				"query_begin" => "",
				"query_end" => "\r\n",
				"redirect" => "0",
				"redirect_string" => "",
				"no_match_string" => "No Data Found",
				"match_string" => "Domain Name:",
				"encoding" => "UTF-8"
			),
			"whois.biz" => array(
				"port" => "43",
				"query_begin" => "",
				"query_end" => "\r\n",
				"redirect" => "0",
				"redirect_string" => "",
				"no_match_string" => "Not found:",
				"match_string" => "Registrant Name:",
				"encoding" => "iso-8859-1"
			),
			"whois.cira.ca" => array(
				"port" => "43",
				"query_begin" => "",
				"query_end" => "\r\n",
				"redirect" => "0",
				"redirect_string" => "",
				"no_match_string" => "Domain status:         available",
				"match_string" => "Domain status:         registered",
				"encoding" => "UTF-8"
			),
			"whois.nic.uk" => array(
				"port" => "43",
				"query_begin" => "",
				"query_end" => "\r\n",
				"redirect" => "0",
				"redirect_string" => "",
				"no_match_string" => "No match for",
				"encoding" => "iso-8859-1"
			),
			"whois.publicinterestregistry.net" => array(
				"port" => "43",
				"query_begin" => "",
				"query_end" => "\r\n",
				"redirect" => "0",
				"redirect_string" => "",
				"no_match_string" => "NOT FOUND",
				"encoding" => "iso-8859-1"
			),
			"whois.verisign-grs.com" => array(
				"port" => "43",
				"query_begin" => "domain ",
				"query_end" => "\r\n",
				"redirect" => "1",
				"redirect_string" => "Whois Server:",
				"no_match_string" => "No match for domain",
				"encoding" => "iso-8859-1"
			)
		);
		$whois_server          = $supported_extensions[$extension]['whois_server'];
		$port                  = $whois_servers[$whois_server]['port'];
		$query_begin           = $whois_servers[$whois_server]['query_begin'];
		$query_end             = $whois_servers[$whois_server]['query_end'];
		$whois_redirect_check  = $whois_servers[$whois_server]['redirect'];
		$whois_redirect_string = $whois_servers[$whois_server]['redirect_string'];
		$no_match_string       = $whois_servers[$whois_server]['no_match_string'];
		$encoding              = $whois_servers[$whois_server]['encoding'];
		$whois_redirect_server = "";
		$response              = "";
		$line                  = "";
		$fp                    = fsockopen($whois_server, $port, $errno, $errstr, $connection_timeout);
		if (!$fp) {
			echo "fsockopen() error when trying to connect to {$whois_server}<br><br>Error number: " . $errno . "<br>" . "Error message: " . $errstr;
			exit;
		}
		fputs($fp, $query_begin . $domain . $extension . $query_end);
		while (!feof($fp)) {
			$line = fgets($fp);
			$response .= $line;
			if ($whois_redirect_check && stristr($line, $whois_redirect_string)) {
				$whois_redirect_server = trim(str_replace($whois_redirect_string, "", $line));
				break;
			}
		}
		fclose($fp);
		if ($whois_redirect_server) {
			$whois_server       = $whois_redirect_server;
			$port               = "43";
			$connection_timeout = 5;
			$query_begin        = "";
			$query_end          = "\r\n";
			$response           = "";
			$fp                 = fsockopen($whois_server, $port, $errno, $errstr, $connection_timeout);
			if (!$fp) {
				echo "fsockopen() error when trying to connect to {$whois_server}<br><br>Error number: " . $errno . "<br>" . "Error message: " . $errstr;
				exit;
			}
			fputs($fp, $query_begin . $domain . $extension . $query_end);
			while (!feof($fp)) {
				$response .= fgets($fp);
			}
			fclose($fp);
		}
		$domain_registered_message = "";
		if (stristr($response, $no_match_string)) {
			$domain_registered_message = "<span style=\"color:#009900\"><b>{$domain}{$extension} chưa có ai đăng ký!</b></span>";
		} else {
			$domain_registered_message = "<b>{$domain}{$extension} đã được đăng ký!</b>";
		}
	}
}
if (!isset($encoding)) {
	$encoding = "UTF-8";
}

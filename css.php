<?php
if ($internal_style_sheet) {
	echo "<style type=\"text/css\">\n";
	echo "body{font-family:{$body_font_family}; font-size:{$body_font_size}; background:{$body_background}; color:{$body_color}; padding:{$body_padding}; border:{$body_border}; margin:{$body_margin};}\n";
	echo "hr{border:0; height:1px; background:{$hr_background}; color:{$hr_color};}\n";
	echo "a:link{text-decoration:{$link_text_decoration}; color:{$link_color}; background:{$link_background};}\n";
	echo "a:hover{text-decoration:{$link_hover_text_decoration}; color:{$link_hover_color}; background:{$link_hover_background};}\n";
	echo "a:visited{text-decoration:{$link_visited_text_decoration}; color:{$link_visited_color}; background:{$link_visited_background};}\n";
	echo "a:active{text-decoration:{$link_active_text_decoration}; color:{$link_active_color}; background:{$link_active_background};}\n";
	echo ".container{width:800px; background:{$container_background}; word-wrap:break-word; padding:20px; margin-left:auto; margin-right:auto;}\n";
	echo "#title_link{font-size:{$title_link_font_size}; color:{$title_link_color}; text-decoration:{$title_link_text_decoration}; background:{$title_link_background};}\n";
	echo ".error_messages{color:{$error_messages_color};}\n";
	echo "#lookup_form{display:inline-block; background:{$form_background}; padding:5px; border:1px solid {$form_border};}\n";
	echo ".response_display{background:{$response_display_background}; width:600px; padding:10px; word-wrap:break-word;}\n";
	echo ".domain_available_message{color:{$domain_available_message_color};}\n";
	echo "</style>\n";
} elseif ($external_style_sheet) {
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$external_style_sheet_location}\">";
}

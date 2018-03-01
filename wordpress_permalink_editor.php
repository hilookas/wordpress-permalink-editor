<?php
/**
 * @package Wordpress_Permalink_Editor
 * @version 1.0
 */

/**
 * Plugin Name: Wordpress Permalink Editor
 * Plugin URI: https://www.lookas2001.com
 * Description: Force to display preset permalink edit box.
 * Version: 1.0
 * Author: Lookas2001
 * Author URI: https://www.lookas2001.com
 */

/*
 * wordpress固定链接渲染过程
 * 访问 wp-admin/post.php
 * 调用 wp-admin/edit-form-advanced.php 渲染html
 * 调用 wp-admin/includes/post.php get_sample_permalink_html 函数
 * 调用 wp-admin/includes/post.php get_sample_permalink 函数
 * 调用 wp-includes/link-template.php get_permalink 函数
 *
 * 其中 get_sample_permalink_html 负责渲染固定链接，该函数会观察其调用的 get_sample_permalink 的函数返回的 url 中是否含有 %postname% %pagename% 字样，如果有，在相应位置插入编辑框。
 *
 * 其中 get_sample_permalink 函数返回的 url 是由 get_permalink 函数返回的。
 *
 * 另外，如果仅仅使用了编辑按钮修改了固定链接但是没有点击更新按钮更新的话，wordpress是不会更新固定链接数据的。
 *
 * 固定链接在底层存储存储为 posts/post_name 而不是 posts/post_title
 */

// TODO Hardcode 这样太粗暴了，有些时候，如果固定链接的设置不是默认的话会导致这里出现问题

function wordpress_permalink_editor( $permalink ) {
	$url          = parse_url( $permalink[0] );
	$permalink[0] = $url['scheme'] . '://' . $url['host'] . '/' . '%postname%';

	return $permalink;
}

add_filter( 'get_sample_permalink', 'wordpress_permalink_editor' );

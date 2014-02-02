<?
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Comment {
	var $id = 0;
	var $randkey = 0;
	var $author = 0;
	var $link = 0;
	var $date = false;
	var $order = 0;
	var $votes = 0;
	var $voted = false;
	var $karma = 0;
	var $content = '';
	var $read = false;
	var $ip = '';

	const SQL = " SQL_NO_CACHE comment_id as id, comment_type as type, comment_user_id as author, user_login as username, user_email as email, user_karma as user_karma, user_level as user_level, comment_randkey as randkey, comment_link_id as link, comment_order as c_order, comment_votes as votes, comment_karma as karma, comment_ip as ip, user_avatar as avatar, comment_content as content, UNIX_TIMESTAMP(comment_date) as date, UNIX_TIMESTAMP(comment_modified) as modified, favorite_link_id as favorite, vote_value as voted, comment_parent as parent, comment_nested_level as nested_level FROM comments LEFT JOIN favorites ON (@user_id > 0 and favorite_user_id =  @user_id and favorite_type = 'comment' and favorite_link_id = comment_id) LEFT JOIN votes ON (@user_id > 0 and vote_type='comments' and vote_link_id = comment_id and vote_user_id = @user_id), users ";

	const SQL_BASIC = " SQL_NO_CACHE comment_id as id, comment_type as type, comment_user_id as author, comment_randkey as randkey, comment_link_id as link, comment_order as c_order, comment_votes as votes, comment_karma as karma, comment_ip as ip, UNIX_TIMESTAMP(comment_date) as date, UNIX_TIMESTAMP(comment_modified) as modified, comment_parent as parent, comment_nested_level as nested_level FROM comments ";


	static function from_db($id) {
		global $db, $current_user;
		if(($result = $db->get_object("SELECT".Comment::SQL."WHERE comment_id = $id and user_id = comment_user_id", 'Comment'))) {
			$result->order = $result->c_order; // Order is a reserved word in SQL
			$result->read = true;
			if($result->order == 0) $result->update_order();
			return $result;
		}
		return false;
	}

	function store($full = true) {
		require_once(mnminclude.'log.php');
		global $db, $current_user, $globals;

		if(!$this->date) $this->date=$globals['now'];
		$comment_author = $this->author;
		$comment_link = $this->link;
		$comment_karma = $this->karma;
		$comment_date = $this->date;
		$comment_randkey = $this->randkey;
		$comment_content = $db->escape($this->normalize_content());
    $comment_parent = $this->parent;
    $comment_nested_level = (int)$this->nested_level;
		if ($this->type == 'admin') $comment_type = 'admin';
		else $comment_type = 'normal';
		$db->transaction();
		if($this->id===0) {
			$this->ip = $db->escape($globals['user_ip']);
			$db->query("INSERT INTO comments (comment_user_id, comment_link_id, comment_type, comment_karma, comment_ip, comment_date, comment_randkey, comment_content, comment_parent, comment_nested_level) VALUES ($comment_author, $comment_link, '$comment_type', $comment_karma, '$this->ip', FROM_UNIXTIME($comment_date), $comment_randkey, '$comment_content', '$comment_parent', '$comment_nested_level')");
			$this->id = $db->insert_id;

            // tabela para resposta de comentarios
            if ($globals["chuzamail"]) {
                $db->query("INSERT DELAYED INTO chuzamail (chm_comment_id, chm_user_id, chm_link_id) VALUES ( $this->id, $comment_author, $comment_link )"); 
            }

			// Insert comment_new event into logs
			if ($full) log_insert('comment_new', $this->id, $current_user->user_id);
		} else {
			$db->query("UPDATE comments set comment_user_id=$comment_author, comment_link_id=$comment_link, comment_type='$comment_type', comment_karma=$comment_karma, comment_ip = '$this->ip', comment_date=FROM_UNIXTIME($comment_date), comment_modified=now(), comment_randkey=$comment_randkey, comment_content='$comment_content', comment_nested_level='$comment_nested_level' WHERE comment_id=$this->id");
			// Insert comment_new event into logs
			if ($full) log_conditional_insert('comment_edit', $this->id, $current_user->user_id, 60);
		}
		if ($full) {
			$this->update_order();
			$this->update_conversation();
		}
		$db->commit();
	}

	function update_order() {
		global $db;

		if ($this->id == 0 || $this->link == 0) return false;
		$order = intval($db->get_var("select count(*) from comments where comment_link_id=$this->link and comment_id < $this->id"))+1;
		if ($order != $this->order) {
			$this->order = $order;
			$db->query("update comments set comment_order=$this->order where comment_id=$this->id");
		}
		return $this->order;
	}
	
	function read() {
		global $db, $current_user;
		$id = $this->id;
		if(($result = $db->get_row("SELECT".Comment::SQL."WHERE comment_id = $id and user_id = comment_user_id"))) {
			foreach(get_object_vars($result) as $var => $value) $this->$var = $value;
			$this->order = $this->c_order; // Order is a reserved word in SQL
			$this->read = true;
			if($this->order == 0) $this->update_order();
			return true;
		}
		$this->read = false;
		return false;
	}

	function read_basic() {
		global $db, $current_user;
		$id = $this->id;
		if(($result = $db->get_row("SELECT".Comment::SQL_BASIC."WHERE comment_id = $id"))) {
			foreach(get_object_vars($result) as $var => $value) $this->$var = $value;
			$this->order = $this->c_order; // Order is a reserved word in SQL
			$this->read = true;
			if($this->order == 0) $this->update_order();
			return true;
		}
		$this->read = false;
		return false;
	}


	function print_summary($link = 0, $length = 0, $single_link=true, $no_padding = false) {
		global $current_user, $globals;

		if(!$this->read) return;

		if (! $link && $this->link > 0) {
			$link = new Link;
			$link->id = $this->link;
			$link->read();
			$this->link_object = $link;
		}


		if ($single_link) $html_id = $this->order;
		else $html_id = $this->id;


    if ($this->nested_level == 1) 
      $no_padding = true;

    if ($no_padding) {
      $padding = 0;//(int)$this->level * 30;
    } else {
      $padding = 33;//(int)$this->level * 30;
    }

		//echo '<div id="c-'.$html_id.'" class="'.(($this->nested_level>1)?'cmt':'cmt').'" style="margin-left:'.$padding.'px;" >';
    echo '<style>';
    echo '
div.cmt {
  border-width:0px 0px 0px 1px;
  border-style:dotted;
  border-color:#AADB7A;
}';
    echo '</style>';
		echo '<div id="c-'.$html_id.'" class="'.(($this->nested_level>1)?'cmt':'').'" style="margin-left:'.$padding.'px;" >';

    /*
		if ($this->type != 'admin' && $this->user_level != 'disabled') {
			// Print the votes info (left)

			if ($current_user->user_id > 0 
						&& $this->author != $current_user->user_id 
						&& $single_link
						&& $this->date > $globals['now'] - $globals['time_enabled_comments']
						&& $this->level != 'autodisabled') {
      */
				$this->print_shake_icons();
        /*
            } else {

                echo '<div style="float:left">';
                echo '<span id="c-votes-'.$this->id.'">';
                echo '<a href="javascript:menealo_comment('."$current_user->user_id,$this->id,1".')" title="'._('informativo, opinión razonada, buen humor...').'"><img src="'.$globals['base_static'].'img/common/vote-up02.png" width="18" height="16" alt="'._('voto positivo').'"/></a><br/>';
                echo '<a href="javascript:menealo_comment('."$current_user->user_id,$this->id,-1".')" title="'._('abuso, insulto, acoso, spam, magufo...').'"><img style="padding-top:5px;" src="'.$globals['base_static'].'img/common/vote-down02.png" width="18" height="16" alt="'._('voto negativo').'"/></a>&nbsp;';
                echo '</span>';
                echo '</div>';
            }
    }
         */

		$this->ignored = ($current_user->user_id > 0 && $this->type != 'admin' && User::friend_exists($current_user->user_id, $this->author) < 0);
		$this->hidden = ($globals['comment_highlight_karma'] > 0 && $this->karma < -$globals['comment_highlight_karma'])
						|| ($this->user_level == 'disabled' && $this->type != 'admin');

		if ($this->hidden || $this->ignored)  {
			$comment_meta_class = 'comment-meta-hidden';
			$comment_class = 'comment-body-hidden';
		} else {
			$comment_meta_class = 'comment-meta';
			$comment_class = 'comment-body';
			if ($this->type == 'admin') {
				$comment_class .= ' admin';
			} elseif ($globals['comment_highlight_karma'] > 0 && $this->karma > $globals['comment_highlight_karma']) {
				$comment_class .= ' high';
			}
		}
		$this->link_permalink =  $link->get_relative_permalink();

    /*
    $bgcolor = Array("R"=>hexdec("C5"),"G"=>hexdec("E7"),"B"=>hexdec("A4"));
    $n = $this->nested_level - 1;
    $bgcolor["R"] = min($bgcolor["R"] + (((255 - $bgcolor["R"]) / 5) * $n), 255);
    $bgcolor["G"] = min($bgcolor["G"] + (((255 - $bgcolor["G"]) / 5) * $n), 255);
    $bgcolor["B"] = min($bgcolor["B"] + (((255 - $bgcolor["B"]) / 5) * $n), 255);
    $bgcolor = dechex($bgcolor["R"]) . dechex($bgcolor["G"]) . dechex($bgcolor["B"]); 
     */
    $color_list = Array( '#C5E7A4',
      '#C4E6A2',
      '#A2E6A2',
      '#A2E6C4',
      '#A2E6E6',
      '#A2C4E6',
      '#A2A2E6',
      '#C4A2E6',
      '#E6A2E6',
      '#E6A2C4',
      '#E6A2A2',
      '#E6C4A2',
      '#E6E6A2',
      '#A6DA72',
      '#87CD42',
      '#A672DA',
      '#8742CD'
    );

    $bgcolor = $color_list[$this->nested_level];
    if (empty($bgcolor)) 
      $bgcolor = end($color_list);

		//echo '<div class="'.$comment_class.'" style="margin-bottom:10px;padding-bottom:5px;background-color:'.$bgcolor.' !important;">';
		echo '<div class="'.$comment_class.'" style="margin-bottom:10px;padding-bottom:5px;background-color:white;min-width:600px;">';
		//echo '<a href="'.$this->link_permalink.'/000'.$this->order.'"><strong>#'.$this->order.'</strong></a>';
    echo '<a href="#" class="f-'.$this->id.' fold" style="font-family:verdana;font-size:x-small;" ></strong>(-)</strong></a>';

		//echo '&nbsp;&nbsp;&nbsp;<span  id="cid-'.$this->id.'">';
		echo '&nbsp;&nbsp;<span  id="cid-'.$this->id.'">';

		if ($this->ignored || ($this->hidden && ($current_user->user_comment_pref & 1) == 0)) {
			echo '&#187;&nbsp;<a href="javascript:get_votes(\'get_comment.php\',\'comment\',\'cid-'.$this->id.'\',0,'.$this->id.')" title="'._('ver comentario').'">'._('ver comentario').'</a>';
		echo '</span>';
		} else {
			$this->print_text($length, $html_id);
			echo '</span>';
		}
		//echo '</div>';
    

		// The comments info bar
		echo '<div class="'.$comment_meta_class.' comment_mc" >';
		// Check that the user can vote
		echo '<div class="comment-votes-info">';

    echo '<a class="comment_vi" href="#c-'.$this->c_order.'" >#'.$this->c_order.'</a> ';

		if ($this->type != 'admin' && $this->user_level != 'disabled') {
			// Print the votes info (left)

      /*
			if ($current_user->user_id > 0 
						&& $this->author != $current_user->user_id 
						&& $single_link
						&& $this->date > $globals['now'] - $globals['time_enabled_comments']
						&& $this->level != 'autodisabled') {
				//$this->print_shake_icons();
			}
       */

			echo _('votos').': <span id="vc-'.$this->id.'">'.$this->votes.'</span>, '._('karma').': <span id="vk-'.$this->id.'">'.$this->karma.'</span>&nbsp;';
			// Add the icon to show votes
			if ($this->votes > 0 && $this->date > $globals['now'] - 30*86400) { // Show votes if newer than 30 days
				echo '<a href="javascript:modal_from_ajax(\''.$globals['base_url'].'backend/get_c_v.php?id='.$this->id.'\')">';
				echo '<img src="'.$globals['base_static'].'img/common/vote-info02.png" width="18" height="16" alt="+ info" title="'._('¿quién ha votado?').'"/>';
				echo '</a>';
			}
		}


		// Comment reply
		if ($current_user->user_id > 0 && $globals['link'] && $globals['link']->date > $globals['now'] - $globals['time_enabled_comments']) {
			echo '<a href="javascript:comment_reply('.$this->order.','.$this->id.')" title="'._('responder').'"><img src="'.$globals['base_static'].'img/common/reply02.png" width="18" height="16"/></a>';
		}
		
		// Comment permalink
		echo '<a href="'.$this->get_relative_individual_permalink().'" title="permalink"><img class="link-icon" src="'.$globals['base_static'].'img/common/link-02.png" width="18" height="16" alt="link" title="'._('enlace permanente').'"/></a>';


		// If the user is authenticated, show favorite box
		if ($current_user->user_id > 0)  {
			echo '<a id="fav-'.$this->id.'" href="javascript:get_votes(\'get_favorite_comment.php\',\''.$current_user->user_id.'\',\'fav-'.$this->id.'\',0,\''.$this->id.'\')">'.favorite_teaser($current_user->user_id, $this, 'comment').'</a>';

		}
		echo '</div>';



    
		// Print comment info (right)
		echo '<div class="comment-info">';

		if ($this->type == 'admin') {
			$author = '<strong>'._('admin').'</strong> ';
			if ($current_user->admin) {
				$author .= ' ('.$this->username.')';
			}
		} elseif ($single_link) {
			$author = '<a href="'.get_user_uri($this->username).'" title="karma:&nbsp;'.$this->user_karma.'" id="cauthor-'.$this->order.'">'.$this->username.'</a>';
		} else {
			$author = '<a href="'.get_user_uri($this->username).'" title="karma:&nbsp;'.$this->user_karma.'">'.$this->username.'</a>';
		}

		// Print dates
		if ($this->modified > $this->date + 1) {
			$edited = sprintf('<strong title="'. _('editado %s después').'">*&nbsp;</strong>', txt_time_diff($this->date, $this->modified));
		} else $edited = '';

		if (!$this->hidden && $this->type != 'admin' && $this->avatar) {
			$avatar = get_avatar_url($this->author, $this->avatar, 20);
		} else {
			$avatar = get_no_avatar_url(20);
		}


		if ($globals['now'] - $this->date > 604800) { // 7 days
			printf(_('el %s %s por %s'), get_date_time($this->date), $edited, $author);
		} else {
			printf(_('fai %s %s por %s'), txt_time_diff($this->date), $edited, $author);
		}
		
		echo '<img src="'.$avatar.'" width="20" height="20" alt="" title="'.$this->username.',&nbsp;karma:&nbsp;'.$this->user_karma.'" />';

		echo '</div>';
     
		echo '</div></div>';
	}

  function print_summary_end() {
		echo "</div>\n";
  }

	function print_shake_icons() {
		global $globals, $current_user;

    echo '<div style="float:left;">';
    echo '<span id="c-votes-'.$this->id.'">';

    if ($this->link_object->association && !in_array($current_user->user_id,$globals['association_users'])) {
      // do nothing if user is not an association member
    } elseif ($this->author == $current_user->user_id) {
			echo '<a href="javascript:return false;" class="sameauthor" title="'._('informativo, opinión razonada, buen humor...').'"><img src="'.$globals['base_static'].'img/common/vote-up-gy02.png" width="18" height="16" alt="'._('voto positivo').'"/></a><br/>';
	 		echo '<a href="javascript:return false;" class="sameauthor" title="'._('abuso, insulto, acoso, spam, magufo...').'"><img style="padding-top:5px;" src="'.$globals['base_static'].'img/common/vote-down-gy02.png" width="18" height="16" alt="'._('voto negativo').'"/></a>&nbsp;';
    } elseif ( $current_user->user_karma > $globals['min_karma_for_comment_votes'] && ! $this->voted) {

			echo '<a href="javascript:menealo_comment('."$current_user->user_id,$this->id,1".')" title="'._('informativo, opinión razonada, buen humor...').'"><img src="'.$globals['base_static'].'img/common/vote-up-gy02.png" width="18" height="16" alt="'._('voto positivo').'"/></a><br/>';
	 		echo '<a href="javascript:menealo_comment('."$current_user->user_id,$this->id,-1".')" title="'._('abuso, insulto, acoso, spam, magufo...').'"><img style="padding-top:5px;" src="'.$globals['base_static'].'img/common/vote-down-gy02.png" width="18" height="16" alt="'._('voto negativo').'"/></a>&nbsp;';
	 	} else {
	 		if ($this->voted > 0) {
				echo '<a href="javascript:menealo_comment('."$current_user->user_id,$this->id,1".')" title="'._('abuso, insulto, acoso, spam, magufo...').'"><img src="'.$globals['base_static'].'img/common/vote-up02.png" width="18" height="16" alt="'._('votado positivo').'" title="'._('votado positivo').'"/></a><br />';
				//echo '<img src="'.$globals['base_static'].'img/common/vote-down-gy02.png" width="18" height="16" alt="'._('votado negativo').'" title="'._('votado negativo').'"/>';
        echo '<a href="javascript:menealo_comment('."$current_user->user_id,$this->id,-1".')" title="'._('abuso, insulto, acoso, spam, magufo...').'"><img style="padding-top:5px;" src="'.$globals['base_static'].'img/common/vote-down-gy02.png" width="18" height="16" alt="'._('voto negativo').'"/></a>&nbsp;';
			} elseif ($this->voted<0 ) {
        echo '<a href="javascript:menealo_comment('."$current_user->user_id,$this->id,1".')" title="'._('informativo, opinión razonada, buen humor...').'"><img src="'.$globals['base_static'].'img/common/vote-up-gy02.png" width="18" height="16" alt="'._('voto positivo').'"/></a><br/>';
				echo '<a href="javascript:menealo_comment('."$current_user->user_id,$this->id,-1".')" title="'._('abuso, insulto, acoso, spam, magufo...').'"><img style="padding-top:5px;" src="'.$globals['base_static'].'img/common/vote-down02.png" width="18" height="16" alt="'._('votado negativo').'" title="'._('votado negativo').'"/></a>';
			}
		}
    echo '</span>';
    echo '</div>';
	}

	function vote_exists() {
		global $current_user;
		$vote = new Vote('comments', $this->id, $current_user->user_id);
		$this->voted = $vote->exists(false);
		if ($this->voted) return $this->voted;
	}

  /**
   * return "OK" only delete
   *        > 0 - usual behavior: first delete then insert
   *        0  error
   */
	function insert_vote($value = 0) {
		global $current_user, $db;

		if (!$value) $value = $current_user->user_karma;

		$vote = new Vote('comments', $this->id, $current_user->user_id);

    $result = 'CREATE'; // vote doesn't exits?

		if ($old_value = $vote->exists(false)) { // save old vote value
      $result = 'REPLACE';
      $vote->delete_comment_vote($old_value); // always destroy current vote

      // check if they have the same sign
      if ($value * $old_value > 0) {
        return Array('DELETE',$old_value); // equal => only delete
      }
		}

		// Affinity
		if ($current_user->user_id != $this->author
				&& ($affinity = User::get_affinity($this->author, $current_user->user_id)) ) {
			if ($value < -1 && $affinity < 0) {
					$value = round(min(-1, $value *  abs($affinity/100)));
			} elseif ($value > 1 && $affinity > 0) {
					$value = round(max($value * $affinity/100, 1));
			}
		}

    $value>0?$svalue='+'.$value:$svalue=$value;

		$vote->value = $value;
		$db->transaction();
		if($vote->insert()) {
			if ($current_user->user_id != $this->author) {
        //echo "update comments set comment_votes=comment_votes+1, comment_karma=comment_karma$svalue, comment_date=comment_date where comment_id=$this->id";
				$db->query("update comments set comment_votes=comment_votes+1, comment_karma=comment_karma$svalue, comment_date=comment_date where comment_id=$this->id");
			}
		} else {
			$vote->value = false;
		}
		$db->commit();

    if ($result == 'CREATE') {
      return Array($result, $vote->value);
    } else { // replace
      return Array($result, $old_value);
    }
	}


	function print_text($length = 0, $html_id=false) {
		global $current_user, $globals;

		if (!$html_id) $html_id = $this->id;

		if (!$this->basic_summary && (
					($this->author == $current_user->user_id && $globals['now'] - $this->date < $globals['comment_edit_time']) 
					|| (($this->author != $current_user->user_id || $this->type == 'admin')
					&& $current_user->user_level == 'god')) ) { // gods can always edit 
			$expand = '&nbsp;&nbsp;<a href="javascript:get_votes(\'comment_edit.php\',\'edit_comment\',\'c-'.$html_id.'\',0,'.$this->id.')" title="'._('editar comentario').'"><img class="mini-icon-text" src="'.$globals['base_static'].'img/common/edit-misc01.png" alt="edit" width="18" height="12"/></a>';

		} 
		if ($length > 0 && mb_strlen($this->content) > $length + $length/2) {

			$this->content = preg_replace('/[&<\{]\w*$/', '', mb_substr($this->content, 0 , $length));
			// Check all html tags are closed
			if (preg_match('/<\w+>/', $this->content)) {
				$this->content = close_tags($this->content);
			}
			$this->content = preg_replace('/&\w*$|<\w{1,6}>([^<>]*)$/', "$1", mb_substr($this->content, 0 , $length));
			$expand .= '&nbsp;&nbsp;' .
				'<a href="javascript:get_votes(\'get_comment.php\',\'comment\',\'cid-'.$this->id.'\',0,'.$this->id.')" title="'._('resto del comentario').'">&#187;&nbsp;'._('ver todo el comentario').'</a>';
		}

		echo put_smileys($this->put_comment_tooltips(save_text_to_html($this->content, 'comments'))) . $expand;
		echo "\n";
	}

	function username() {
		global $db;
//TODO
		$this->username = $db->get_var("SELECT SQL_CACHE user_login FROM users WHERE user_id = $this->author");
		return $this->username;
	}

	// Add calls for tooltip javascript functions
	function put_comment_tooltips($str) {
		if ($this->basic_summary) $type = 'order'; // Forces to call the backend
		else $type = 'id'; // It tries fist with DOM info, then the backend
		return preg_replace('/(^|[\(,;\.\s])#([0-9]+)/', "$1<a class='tt' href=\"".$this->link_permalink."/000$2\" onmouseover=\"return tooltip.c_show(event, '$type', '$2', '".$this->link."');\" onmouseout=\"tooltip.hide(event);\"  onclick=\"tooltip.hide(this);\">#$2</a>", $str);
	}

	function same_text_count($min=30) {
		global $db;
		// WARNING: $db->escape(clean_lines($comment->content)) should be the sama as in libs/comment.php (unify both!)
		return (int) $db->get_var("select count(*) from comments where comment_user_id = $this->author  and comment_date > date_sub(now(), interval $min minute) and comment_content = '".$db->escape(clean_lines($this->content))."'");
	}

	function get_links() {
		global $current_user;

		$this->links = array();
		$this->banned = false;

		$localdomain = preg_quote(get_server_name(), '/');
		preg_match_all('/([\(\[:\.\s]|^)(https*:\/\/[^ \t\n\r\]\(\)\&]{5,70}[^ \t\n\r\]\(\)]*[^ .\t,\n\r\(\)\"\'\]\?])/i', $this->content, $matches);
		foreach ($matches[2] as $match) {
			require_once(mnminclude.'ban.php');
			$link=clean_input_url($match);
			$components = parse_url($link);
			if ($components && ! preg_match("/.*$localdomain$/", $components['host'])) {
				$link_ban = check_ban($link, 'hostname', false, true); // Mark this comment as containing a banned link
				$this->banned |= $link_ban;
				if ($link_ban) { 	
					syslog(LOG_NOTICE, "Meneame: banned link in comment: $match ($current_user->user_login)");
				}
				if (array_search($components['host'], $this->links) === false)
					array_push($this->links, $components['host']);
			}
		}
	}

	function same_links_count($min=30) {
		global $db, $current_user;

		if ($this->id > 0) {
			$not_me = "and comment_id != $this->id";
		} else {
			$not_me = '';
		}

		$count = 0;
		$localdomain = preg_quote(get_server_name(), '/');
		foreach ($this->links as $host) {
			if ($this->banned) $interval = $min * 2;
			elseif (preg_match("/.*$localdomain$/", $host)) $interval = $min / 3; // For those pointing to dupes
			else $interval = $min;

			$link = '://'.$host;
			$link=preg_replace('/([_%])/', "\$1", $link);
			$link=$db->escape($link);
			$same_count = (int) $db->get_var("select count(*) from comments where comment_user_id = $this->author and comment_date > date_sub(now(), interval $interval minute) and comment_content like '%$link%' $not_me");
			$count = max($count, $same_count);
		}
		return $count;
	}

	// Static function to print comment form
	static function print_form($link, $rows=12) {
		global $current_user, $globals;

		if (!$link->votes > 0) return;
    if ($link->association && !in_array($current_user->user_id, $globals['association_users'])) {
      // so a xente da asociacion pode comentar aqui
			echo '<div class="commentform warn">'."\n";
			echo _('Tes que ser da asociación para poder comentar nesta noticia')."\n";
			echo '</div>'."\n";
    } elseif($link->date < $globals['now']-$globals['time_enabled_comments'] || $link->comments >= $globals['max_comments']) {
			// Comments already closed
			echo '<div class="commentform warn">'."\n";
			echo _('comentarios cerrados')."\n";
			echo '</div>'."\n";
		} elseif ($current_user->authenticated 
					&& (($current_user->user_karma > $globals['min_karma_for_comments'] 
							&& $current_user->user_date < $globals['now'] - $globals['min_time_for_comments']) 
						|| $current_user->user_id == $link->author)) {
			// User can comment
			echo '<div class="commentform">'."\n";
			echo '<form action="" method="post">'."\n";
			echo '<fieldset>'."\n";
			echo '<legend>'._('envía un comentario'). ' <em style="font-size:80%">'._('porque alguien en Internet está equivocado').'</em></legend>'."\n";
			print_simpleformat_buttons('comment');
			echo '<label for="comment">'. _('texto del comentario / no se admiten etiquetas HTML').'<br /><span class="note">'._('comentarios xenófobos, racistas o difamatorios causarán la anulación de la cuenta').'</span></label>'."\n";
			echo '<div><textarea name="comment_content" id="comment" cols="75" rows="'.$rows.'"></textarea></div>'."\n";
			echo '<input class="button" type="submit" name="submit" value="'._('enviar el comentario').'" />'."\n";
			// Allow gods to put "admin" comments which does not allow votes
			if ($current_user->user_level == 'god') {
				echo '&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>'._('admin').' </strong><input name="type" type="checkbox" value="admin"/></label>'."\n";
			}
			echo '<input type="hidden" name="process" value="newcomment" />'."\n";
			echo '<input type="hidden" name="randkey" value="'.rand(1000000,100000000).'" />'."\n";
			echo '<input type="hidden" name="link_id" value="'.$link->id.'" />'."\n";
			echo '<input type="hidden" name="user_id" value="'.$current_user->user_id.'" />'."\n";
			echo '<input type="hidden" name="parent_id" value="0" />'."\n"; // for comment replies
			echo '</fieldset>'."\n";
			echo '</form>'."\n";
			echo "</div>\n";
      echo '<div style="visibility:hidden;text-align:center;" id="comentarNoticia" ><a href="#" >'._("Comentar Noticia").'</a></div>'."\n";
		} else {
			// Not enough karma or anonymous user
			if($tab_option == 1) do_comment_pages($link->comments, $current_page);
			if ($current_user->authenticated) {
				if ($current_user->user_date >= $globals['now'] - $globals['min_time_for_comments']) {
					$remaining = txt_time_diff($globals['now'], $current_user->user_date+$globals['min_time_for_comments']);
					$msg = _('debes esperar') . " $remaining " . _('para escribir el primer comentario');
				}
				if ($current_user->user_karma <= $globals['min_karma_for_comments']) {
					$msg = _('no tienes el mínimo karma requerido')." (" . $globals['min_karma_for_comments'] . ") ". _('para comentar'). ": ".$current_user->user_karma;
				}
				echo '<div class="commentform warn">'."\n";
				echo $msg . "\n";
				echo '</div>'."\n";
			} elseif (!$globals['bot']){
				echo '<div class="commentform warn">'."\n";
				echo '<a href="'.get_auth_link().'login.php?return='.$_SERVER['REQUEST_URI'].'">'._('Autentifícate si deseas escribir').'</a> '._('comentarios').'. '._('O crea tu cuenta'). ' <a href="'.$globals['base_url'].'register.php">aquí.</a>'."\n";
				echo '</div>'."\n";

				echo '<div style="margin-top: 20px" align="center">';
				print_oauth_icons();
				echo '</div>'."\n";
			}
		}
	}


	static function save_from_post($link) {
		global $db, $current_user, $globals;

		require_once(mnminclude.'ban.php');

		$error = '';
		if(check_ban_proxy() && !$globals['development']) return _('dirección IP no permitida');

		// Check if is a POST of a comment

		if( ! ($link->votes > 0 && $link->date > $globals['now']-$globals['time_enabled_comments']*1.01 && 
				$link->comments < $globals['max_comments'] &&
				intval($_POST['link_id']) == $link->id && $current_user->authenticated && 
				intval($_POST['user_id']) == $current_user->user_id &&
				intval($_POST['randkey']) > 0
				)) {
			return _('comentario o usuario incorrecto');
		}

		if ($current_user->user_karma < $globals['min_karma_for_comments'] && $current_user->user_id != $link->author) {
			return _('karma demasiado bajo');
		}

		$comment = new Comment;

		$comment->link=$link->id;
		$comment->ip = $db->escape($globals['user_ip']);
		$comment->randkey=intval($_POST['randkey']);
		$comment->author=intval($_POST['user_id']);
		$comment->karma=round($current_user->user_karma);
		$comment->content=clean_text_with_tags($_POST['comment_content'], 0, false, 10000);
    $comment->parent=intval($_POST['parent_id']);

    //get level
    $parentComment = new Comment();
    $parentComment->id = intval($comment->parent);
    $parentComment->read_basic();
    if ($parentComment->nested_level > $globals['NESTED_COMMENTS_MAX_LEVEL']) {
				return _('Chegache ao nivel límite de comentarios aniñados...');
    }
    $comment->nested_level = $parentComment->nested_level + 1;


		// Check if is an admin comment
		if ($current_user->user_level == 'god' && $_POST['type'] == 'admin') {
			$comment->type = 'admin';
		} 

		// Don't allow to comment with a clone
		$hours = intval($globals['user_comments_clon_interval']);
		if ($hours > 0) {
			$clones = $current_user->get_clones($hours+1);
			if ( $clones) {
				$l = implode(',', $clones);
				$c = (int) $db->get_var("select count(*) from comments where comment_date > date_sub(now(), interval $hours hour) and comment_user_id in ($l)");
				if ($c > 0) {
					syslog(LOG_NOTICE, "Meneame, clon comment ($current_user->user_login, $comment->ip) in $link->uri");
					return _('ya hizo un comentario con usuarios clones');
				}
			}
		}

		// Basic check to avoid abuses from same IP
		if (!$current_user->admin && $current_user->user_karma < 6.2) { // Don't check in case of admin comments or higher karma

			// Avoid astroturfing from the same link's author
			if ($link->status != 'published' && $link->ip == $globals['user_ip'] && $link->author != $comment->author) {
				UserAuth::insert_clon($comment->author, $link->author, $link->ip);
				syslog(LOG_NOTICE, "Meneame, comment-link astroturfing ($current_user->user_login, $link->ip): ".$link->get_permalink());
				return _('no se puede comentar desde la misma IP del autor del envío');
			}

			// Avoid floods with clones from the same IP
			if (intval($db->get_var("select count(*) from comments where comment_link_id = $link->id and comment_ip='$comment->ip' and comment_user_id != $comment->author")) > 1) {
				syslog(LOG_NOTICE, "Meneame, comment astroturfing ($current_user->user_login, $comment->ip)");
				return _('demasiados comentarios desde la misma IP con usuarios diferentes');
			}
		}


		if (mb_strlen($comment->content) < 5 || ! preg_match('/[a-zA-Z:-]/', $_POST['comment_content'])) { // Check there are at least a valid char
			return _('texto muy breve o caracteres no válidos');
		}


		// Check the comment wasn't already stored
		$already_stored = intval($db->get_var("select count(*) from comments where comment_link_id = $comment->link and comment_user_id = $comment->author and comment_randkey = $comment->randkey"));
		if ($already_stored) {
			return _('comentario duplicado');
		}

		if (! $current_user->admin) {
			$comment->get_links();
			if ($comment->banned && $current_user->Date() > $globals['now'] - 86400) {
				syslog(LOG_NOTICE, "Meneame: comment not inserted, banned link ($current_user->user_login)");
				return _('comentario no insertado, enlace a sitio deshabilitado (y usuario reciente)');
			}

			// Lower karma to comments' spammers
			$comment_count = (int) $db->get_var("select count(*) from comments where comment_user_id = $current_user->user_id and comment_date > date_sub(now(), interval 3 minute)");
			// Check the text is not the same
			$same_count = $comment->same_text_count();
			$same_links_count = $comment->same_links_count();
			if ($comment->banned) $same_links_count *= 2;
			$same_count += $same_links_count;
		} else {
			$comment_count  = $same_count = 0;
		}

		$comment_limit = round(min($current_user->user_karma/6, 2) * 2.5);
		if ($comment_count > $comment_limit || $same_count > 2) {
			$reduction = 0;
			if ($comment_count > $comment_limit) {
				$reduction += ($comment_count-3) * 0.1;
			}
			if($same_count > 1) {
				$reduction += $same_count * 0.25;
			}
			if ($reduction > 0) {
				$user = new User;
				$user->id = $current_user->user_id;
				$user->read();
				$user->karma = $user->karma - $reduction;
				syslog(LOG_NOTICE, "Meneame: story decreasing $reduction of karma to $current_user->user_login (now $user->karma)");
				$user->store();
				$annotation = new Annotation("karma-$user->id");
				$annotation->append(_('texto repetido o abuso de enlaces en comentarios').": -$reduction, karma: $user->karma\n");
				$error .= ' ' . ('penalización de karma por texto repetido o abuso de enlaces');
			}
		}
		$db->transaction();
		$comment->store();
		$comment->insert_vote();
		$link->update_comments();
		$db->commit();
		// Comment stored, just redirect to it page
		header('Location: '.$link->get_permalink() . '#c-'.$comment->order);
		die;
		//return $error;
	}

	function update_conversation() {
		global $db, $globals;

		$db->query("delete from conversations where conversation_type='comment' and conversation_from=$this->id");
		$orders = array();
		if (preg_match_all('/(^|[\(,;\.\s])#(\d+)/', $this->content, $matches)) {
			foreach ($matches[2] as $order) {
				$orders[$order] += 1;
			}
		}
		if (!$this->date) $this->date = time();
		$references = array();
		foreach ($orders as $order => $val) {
			if ($order == 0) {
				$to = $db->get_row("select 0 as id, link_author as user_id from links where link_id = $this->link");
			} else {
				$to = $db->get_row("select comment_id as id, comment_user_id as user_id from comments where comment_link_id = $this->link and comment_order=$order and comment_type != 'admin'");
			}
			if ($to) {
				if (!$references[$to->id]) {
					$db->query("insert into conversations (conversation_user_to, conversation_type, conversation_time, conversation_from, conversation_to) values ($to->user_id, 'comment', from_unixtime($this->date), $this->id, $to->id)");
					$references[$to->id] = true;
				}
			}
		}

	}

	function get_relative_individual_permalink() {
		// Permalink of the "comment page"
		global $globals;
		if ($globals['base_comment_url']) {
			return $globals['base_url'] . $globals['base_comment_url'] . $this->id;
		} else {
			return $globals['base_url'] . 'comment.php?id=' . $this->id;
		}
	}

	function normalize_content() {
		$this->content = clean_lines(normalize_smileys($this->content));
		return $this->content;
	}

    static function getChuzaMail($user_id, $retResults=false, $refresh=false) {
        global $globals, $db; 

        if ($globals['chuzamail'] && !empty($globals['chuzamail_content']) && !$refresh) {
            if ($retResults) {
                return array_keys($globals['chuzamail_content']);
            } else {
                return count($globals['chuzamail_content'])>0?true:false;
            }
        }

        $s = "SELECT chm_id,chm_user_id,chm_link_id FROM `chuzamail` WHERE chm_link_id IN (SELECT chm_link_id FROM chuzamail WHERE chm_user_id = $user_id AND chm_viewed = 0) ORDER BY chm_date";
        $r = $db->get_results($s);
        if (empty($r)) {
            return false;
        }

        $mails = Array();
        foreach($r as $kay=>&$val) {
            $mails[$val->chm_link_id] = $val->chm_user_id;  
        }
        foreach($mails as $kay=>$val) {
            if ($val == $user_id) unset($mails[$kay]);
        } 
        
        $globals['chuzamail_content'] = $mails;
        
        if ($retResults) {
            return array_keys($mails);
        } else {
            return count($mails)>0?true:false;
        }

    }
}
?>

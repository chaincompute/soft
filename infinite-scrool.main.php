$this->output( '<script src="' . $this->rooturl . 'js/main.js"></script>' );
		$this->output( '<script src="' . $this->rooturl . 'js/bootstrap.min.js"></script>' );

		if ( 'questions' == $this->template || 'hot' == $this->template || 'search' == $this->template || 'updates' == $this->template || 'user-questions' == $this->template || 'favorites' == $this->template || 'qa' == $this->template || 'tag' == $this->template || 'type' == $this->template || 'reactions' == $this->template ) {
			$this->output( '<script src="' . $this->rooturl . 'js/jquery-ias.min.js"></script>' );
			$this->output( '<script src="' . $this->rooturl . 'js/masonry.pkgd.min.js"></script>' );
		}

	}


public function body_content() {
		$this->body_prefix();
		$this->notices();
		$this->body_header();
		$this->header();
		$this->main_up();
		$this->output( '<DIV id="king-body-wrapper" class="king-body-in">' );
		$this->widgets( 'full', 'top' );
		$this->featured();
		$this->widgets( 'full', 'high' );
		$this->nav( 'sub' );
		$this->widgets( 'full', 'low' );
		$this->main();
		$this->output( '</DIV>' );
		$this->footer();
		$this->body_suffix();
	}
public function main_up() {
		$content = $this->content;
		$q_view = isset($content['q_view']) ? $content['q_view'] : '';
		
		if ($q_view) {
			
			$text2 = $q_view['raw']['postformat'];
			$nsfw  = $q_view['raw']['nsfw'];
			if ( null !== $nsfw && ! qa_is_logged_in() ) {
				$this->output( '<DIV CLASS="king-video">' );
				$this->output( '<span class="king-nsfw-post"><p><i class="fas fa-mask fa-2x"></i></p>' . qa_lang_html( 'misc/nsfw_post' ) . '</span>' );
				$this->output( '</DIV>' );
			} elseif ( 'V' == $text2 ) {
				$this->output( '<DIV CLASS="king-video-in">' );
				$this->output( '<DIV CLASS="king-video">' );
				$this->q_view_extra( $q_view );
				$this->output( '</DIV>' );
				$this->output( '</DIV>' );
			} elseif ( 'music' == $text2 ) {
				$this->output( '<DIV CLASS="king-video-in">' );
				$this->output( '<DIV CLASS="king-video">' );
				$this->music_view( $q_view );
				$this->output( '</DIV>' );
				$this->output( '</DIV>' );
			} elseif ( 'I' == $text2 ) {
				$this->output( '<DIV CLASS="king-video-in">' );
				$this->output( '<DIV CLASS="king-video">' );
				$this->q_view_extra( $q_view );
				$this->output( '</DIV>' );
				$this->output( '</DIV>' );
			}

		}
	}

	public function q_view( $q_view ) {
		$pid   = $q_view['raw']['postid'];
		$text2 = $q_view['raw']['postformat'];
		$nsfw  = $q_view['raw']['nsfw'];

		if ( ! empty( $q_view ) ) {

			$this->viewtop();
			if ( null == $nsfw || qa_is_logged_in() ) {
				$this->output( '<DIV CLASS="king-q-view' . ( @$q_view['hidden'] ? ' king-q-view-hidden' : '' ) . rtrim( ' ' . @$q_view['classes'] ) . '"' . rtrim( ' ' . @$q_view['tags'] ) . '>' );
				$this->a_count( $q_view );
				$this->output( '<DIV CLASS="rightview">' );
				$this->page_title_error();
				$blockwordspreg = qa_get_block_words_preg();
				$this->output( '<div class="post-content">' . qa_block_words_replace( $q_view['raw']['pcontent'], $blockwordspreg ) . '</div>' );

				if ( 'poll' == $text2 ) {
					$this->get_poll( $pid );
				} elseif ( 'list' == $text2 ) {
					$this->get_list( $pid );
				} elseif ( 'trivia' == $text2 ) {
					$this->get_trivia( $pid );
				}

				$this->post_tags( $q_view, 'king-q-view' );
				$this->view_count( $q_view );
				$this->post_meta_when( $q_view, 'meta' );
				$this->output( '<div class="prev-next">' );
				$this->get_next_q();
				$this->get_prev_q();
				$this->output( '</div>' );
				$this->output( '</DIV>' );
				if ( qa_opt( 'show_ad_post_below' ) ) {
					$this->output( '<div class="ad-below">' );
					$this->output( '' . qa_opt( 'ad_post_below' ) . '' );
					$this->output( '</div>' );
				}
				$this->output( '</DIV> <!-- END king-q-view -->', '' );
			}
			$this->socialshare();
			$this->pboxes( $q_view );
			$this->maincom( $q_view );

		}
	}

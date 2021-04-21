<?php

/**
 * MainController
 * Feel free to delete the methods and replace them with your own code.
 *
 * @author darkredz
 */
class MainController extends SnController {

	/**
	 * Shows game news for specific platform and game
	 *
	 */
	public function topSearch() {
		if (!isset($this->params['searchText'])) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}
		$search = new Search();

		$data['title'] = $this->__('Search results');
		$data['body_class'] = 'index_global_search';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();

		$list = array();
		$list['searchText'] = urldecode($this->params['searchText']);
		$totalResults = $search->getTopSearchTotal(urldecode($this->params['searchText']));
		$pager = $this->appendPagination($list, new stdClass(), $totalResults, MainHelper::site_url('search/' . urlencode($list['searchText'])));

		$list['hideHeader'] = true;

		$list['resultCount'] = $totalResults;
		$list['list'] = $search->getTopSearch(urldecode($this->params['searchText']), $pager->limit);

		$data['content'] = $this->renderBlock('search/top_search', $list);

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Shows game news for specific platform and game
	 *
	 */
/*	public function index() {
		$player = User::getUser();
		if ($player) {
			DooUriRouter::redirect(MainHelper::site_url('players/wall'));
			return FALSE;
		}
		$news = new News();
		$data['title'] = $this->__('PlayNation');
		$data['meta'] = 'Index page';
		$data['body_class'] = 'index_index';
//		$data['right'] = PlayerHelper::playerRightSide();

		$list = array();
		$list['latestNews'] = $news->getLatestNews();

		$data['content'] = $this->renderBlock('index/index', $list);

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		// $this->render2ColsRight($data);
		$this->render1Col($data);
	}
*/
	public function index() {
		$news = new News();
        $list = array();
		$list['NewsCategoriesType'] = FALSE;

        $newsPerPage = Doo::conf()->get('frontpageNewsLimit');

        $frontpage = new NwFrontpage;
		$moduleState = $frontpage->getModuleStates();

		$newsTotal = $news->getNewsTotal();
		$pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('news/page'), $newsPerPage);
        $list['tab'] = $tab = 3;
        $list['order'] = $order = 'desc';
		$list['recentNews'] = $news->getLatestNews($pager->limit, $tab, $order);
		$list['showEvents'] = isset($moduleState['Upcoming Events']['Frontpage']) ? $moduleState['Upcoming Events']['Frontpage'] : '0';
        $xlist['mostReadList'] = $news->getMostReadNews();

		$data['title'] = $this->__('PlayNation');
		$data['meta'] = 'Index page';
		$data['body_class'] = 'index_news';
//		$data['selected_menu'] = 'news';
		$data['right'] = PlayerHelper::playerRightSide($list);
		$data['content']  = $this->renderBlock('news/header');
		if(isset($moduleState['Slider']['Frontpage']) && $moduleState['Slider']['Frontpage']) {
			$data['content'] .= $this->renderBlock('news/slider');
		};
		if(isset($moduleState['Highlights']['Frontpage']) && $moduleState['Highlights']['Frontpage']) {
			$data['content'] .= $this->renderBlock('news/highlights');
		};
		$data['content'] .= '<div id="news_border"> </div>';
		$data['content'] .= $this->renderBlock('news/mostRead', $xlist);
		$data['content'] .= $this->renderBlock('news/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render2ColsRight($data);
	}

	public function closeInfoBox() {
		$result['result'] = false;
		if ($this->isAjax() and !empty($_POST) and Auth::isUserLogged()) {
			if ($_POST['id'] > 0) {
				$id = intval($_POST['id']);
				MainHelper::closeInfoBox($id);
				$result['result'] = true;
			}
		}
		$this->toJSON($result, true);
	}

	public function popup() {
		if ($this->isAjax()) {
			$menu = new DynMenu();
			$menu->menu_id = $this->params['id'];
			$menu->purgeCache();
			$menu = $menu->getOne();
			$data['item'] = $menu;
			echo $this->renderBlock('menu/menupop', $data);
		}
	}

	public function info() {
		if (!isset($this->params['id'])) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$menu = new SyMenu();
		$menu->URL = $this->params['id'];
		$menu->purgeCache();
		$menu = $menu->getOne();

		if (!$menu) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$menu->appendLang();

		$data['title'] = $menu->NameTranslated;
		$data['body_class'] = 'index_global_search';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();

		$list = array();
		$list['item'] = $menu;
		$data['content'] = $this->renderBlock('index/info', $list);

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function updateBlockVisibility() {
		if ($this->isAjax() and isset($this->params['block_name']) and isset($this->params['block_val'])) {
			User::setBlockVisibility($this->params['block_name'], $this->params['block_val']);
		}
	}

	/**
	 * Sets new post on wall
	 *
	 * @return JSON
	 */
	public function ajaxSetPost() {
		if($this->isAjax() and MainHelper::validatePostFields(array('id', 'post', 'type'))) {
			$p = User::getUser();
			$shared = false;
			if($p) {
				$objFrom = null;
				$objTo = null;
				$playerAllowArray = array(
					WALL_OWNER_PLAYER . '_' . WALL_HOME,
					WALL_OWNER_PLAYER . '_' . WALL_LINK,
					WALL_OWNER_PLAYER . '_' . WALL_PHOTO,
					WALL_OWNER_PLAYER . '_' . WALL_VIDEO,
					WALL_OWNER_PLAYER . '_' . WALL_MAIN,
				);
				$friendAllowArray = array(
					WALL_OWNER_FRIEND . '_' . WALL_HOME,
					WALL_OWNER_FRIEND . '_' . WALL_LINK,
					WALL_OWNER_FRIEND . '_' . WALL_PHOTO,
					WALL_OWNER_FRIEND . '_' . WALL_VIDEO,
				);
				if($_POST['type'] == WALL_OWNER_GROUP) {
					$groups = new Groups();
					$objFrom = $p;
					$objTo = $groups->getGroupByID($_POST['id']);
				} else if($_POST['type'] == WALL_OWNER_GROUP_ADMIN) {
					$groups = new Groups();
					$objFrom = $groups->getGroupByID($_POST['id']);
					$objTo = $objFrom;
				} else if($_POST['type'] == WALL_OWNER_GAME) {
					$objFrom = $p;
					$objTo = Games::getGameByID($_POST['id']);
				} else if($_POST['type'] == WALL_OWNER_EVENT) {
					$objFrom = $p;
					$objTo = Event::getEvent($_POST['id']);
				} else if($_POST['type'] == WALL_OWNER_EVENT_ADMIN) {
					$objFrom = Event::getEvent($_POST['id']);
					$objTo = $objFrom;
				} else if(in_array($_POST['type'], $playerAllowArray)) {
					$objFrom = $p;
					$objTo = $objFrom;
				} else if(in_array($_POST['type'], $friendAllowArray)) {
					$objFrom = $p;
					$objTo = User::getFriend($_POST['id']);
				};
				if(!$objFrom || !$objTo) { return; };
				if(MainHelper::validatePostFields(array('otype', 'oid'))) {
					$shared = array(
						'otype' => $_POST['otype'],
						'oid' => $_POST['oid'],
						'olang' => MainHelper::validatePostFields(array('olang')) ? $_POST['olang'] : false
					);
				};
				$wall = new Wall();
				$id = $wall->setPost($objFrom, $objTo, $_POST['post'], WALL_HOME, $shared);
				if($id and $id > 0) {
					$item = $wall->getPost($id);
					if($_POST['type'] == WALL_OWNER_PLAYER . '_' . WALL_VIDEO or $_POST['type'] == WALL_OWNER_FRIEND . '_' . WALL_VIDEO) {
						$list = array();
						$plist = $wall->getPostList($objTo, WALL_VIDEO, 0);
						$val = array('poster' => $objTo, 'items' => $plist, 'offset' => 0);
						$result['content'] = $this->renderBlock('wall/' . WALL_VIDEO . '_gallery', $val);
						$result['total'] = $wall->getTotalPostsByType();
						$this->toJSON($result, true);
					} else if($item) {
						$type = $item->ItemType;
						$val = array('poster' => $objFrom, 'item' => $item, 'num' => 0);
						$result['content'] = $this->renderBlock('wall/' . $type, $val);
						$this->toJSON($result, true);
					};
				};
			};
		};
	}

	public function ajaxGetPosts() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('id', 'type'))) {
			$string = '';
			$wall = new Wall();
			$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
			$list = array();
			$type = '';
			$obj = null;
			$playerAllowArray = array(
				WALL_OWNER_PLAYER . '_' . WALL_HOME,
				WALL_OWNER_PLAYER . '_' . WALL_LINK,
				WALL_OWNER_PLAYER . '_' . WALL_PHOTO,
				WALL_OWNER_PLAYER . '_' . WALL_VIDEO,
				WALL_OWNER_PLAYER . '_' . WALL_MAIN,
			);
			$friendAllowArray = array(
				WALL_OWNER_FRIEND . '_' . WALL_HOME,
				WALL_OWNER_FRIEND . '_' . WALL_LINK,
				WALL_OWNER_FRIEND . '_' . WALL_PHOTO,
				WALL_OWNER_FRIEND . '_' . WALL_VIDEO,
			);

			if ($_POST['type'] == WALL_OWNER_GROUP) {
				$obj = Groups::getGroupByID($_POST['id']);
			} else if ($_POST['type'] == WALL_OWNER_EVENT) {
				$obj = Event::getEvent($_POST['id']);
			} else if (in_array($_POST['type'], $playerAllowArray)) {
				$obj = User::getUser();
				$type = $_POST['type'];
			} else if (in_array($_POST['type'], $friendAllowArray)) {
				$obj = User::getById($_POST['id']);
				$type = $_POST['type'];
			}

			if (!$obj) {
				return;
			}

			MainHelper::getWallPosts($list, $obj, $offset, $type);
			$result['total'] = $list['postTotal'];
			$result['content'] = $list['posts'];
			$this->toJSON($result, true);
		}
	}

	public function ajaxDeletePost() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('pid'))) {
			$wall = new Wall();
			$wallitem = $wall->getPost($_POST['pid'], true);
			if ($wallitem) {
				if (!$wallitem->isOwner()){   // Not owner!
					//---- Remove item from MyWallItems ----
					$player = User::getUser();
					$myWallItems = new SnMyWallItems;
					$myWallItems->ID_WALLITEM = $wallitem->ID_WALLITEM;
					$myWallItems->ID_VIEWER = $player->ID_PLAYER;
					$myWallItems->delete();
					//---- Dec image count for album ----
					$walltags = new SnWalltags;
					$walltags->ID_WALLITEM = $wallitem->ID_WALLITEM;
					$walltags->ID_TAGGED = $player->ID_PLAYER;
					$walltag = $walltags->getOne();
					Album::imageCountDec($walltag->ID_ALBUM);
					$this->toJSON(array('result' => TRUE), true);   // Refresh gallery
					return;
				}
				elseif (($wallitem->isOwner() or $wallitem->isWallOwner()) and $wallitem->deletePost()) { // if it's players or his group's/event's post
					if ($wallitem->ItemType == WALL_PHOTO) {
						Album::imageCountDec($wallitem->ID_ALBUM);
						//---- Remove related tags ----
						$walltags = new SnWalltags;
						$walltags->ID_WALLITEM = $wallitem->ID_WALLITEM;
						$walltags->delete();
						//---- Remove related files from filesystem ----
						$message = unserialize($wallitem->Message);
						$content = unserialize($message['content']);
						$fileName = $content['content'];
						$dir = sprintf('%sglobal/pub_img/%s/%s/%s/', Doo::conf()->SITE_PATH, FOLDER_WALL_PHOTOS, $fileName[0], $fileName[1]);
						$files = preg_replace('/\.\w+$/', '*\\0', $fileName);   // Alter filename.ext to filename*.ext
						foreach(glob($dir.$files) as $file) {
							@unlink($file);
						}
					}
					elseif ($wallitem->ItemType == WALL_ALBUM) {
						$album = new Album;
						$album->remove($wallitem->ID_WALLOWNER, $wallitem->ID_ALBUM);

					}

					$this->toJSON(array('result' => TRUE), true);
					return;
				} elseif ($wallitem->onWall()) { // if on players or his group's/event's wall
				}
			}

			$this->toJSON(array('result' => false), true);
		}
	}

	/**
	 * Renders iframe with photo/video and comments
	 *
	 * @return String
	 */
	public function showPost() {
		$id = intval($this->params['post_id']);
		if ($id > 0) {
			$wall = new Wall();
			$wallitem = $wall->getPost($id, true);

			if (!$wallitem) {
				DooUriRouter::redirect(MainHelper::site_url());
			}

			$data['title'] = $this->__('Post');
			$data['body_class'] = 'index_show_post';
			$data['selected_menu'] = 'players';
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['right'] = PlayerHelper::playerRightSide();

			$postList = '';
			MainHelper::getWallPost($this, $wall, $wallitem, $postList);

			$data['content'] = $postList;
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$this->render3Cols($data);
		} else {
			DooUriRouter::redirect(MainHelper::site_url());
		}
	}

	/**
	 * Sets reply for specified post
	 *
	 * @return JSON
	 */
	public function ajaxSetReply() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('pid', 'comment'))) {
			$p = User::getUser();
			if ($p) {
				$wall = new Wall();
				$id = $wall->setComment($p, $_POST['pid'], $_POST['comment']);
				$item = $wall->getReply($id);
				$string = '';
				if ($item->ID_WALLITEM) {
					$val = array('poster' => $p, 'item' => $item, 'num' => 0);
					$string .= $this->renderBlock('wall/comment', $val);
				}

				$result['total'] = $wall->getTotalRepliesByPostID($_POST['pid']);
				$result['content'] = $string;
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Prints replies list
	 *
	 * @return JSON
	 */
	public function ajaxGetRepliesList() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('pid'))) {
			$wall = new Wall();
			$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
			$rlist = $wall->getRepliesList($_POST['pid'], $offset);

			$string = '';
			if (!empty($rlist)) {
				$num = 0;
				foreach ($rlist as $item) {
					$val = array('poster' => $item->Players, 'item' => $item, 'num' => $num);
					$string .= $this->renderBlock('wall/comment', $val);
					$num++;
				}
			}

			$result['total'] = $wall->getTotalRepliesByPostID($_POST['pid']);
			$result['content'] = $string;
			$this->toJSON($result, true);
		}
	}

	/**
	 * Delete reply from post
	 *
	 * @return JSON
	 */
	public function ajaxDeleteReply() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('pid', 'rid'))) {
			$wallreply = new SnWallreplies();
			$wallreply->ID_WALLITEM = $_POST['pid'];
			$wallreply->ReplyNumber = $_POST['rid'];
			$wallreply = $wallreply->getOne();
			if ($wallreply->ID_WALLITEM && $wallreply->deleteReply() == TRUE) {
				$wall = new Wall();
				$result['total'] = $wall->getTotalRepliesByPostID($_POST['pid']);
				$result['result'] = TRUE;
				$this->toJSON($result, true);
			} else {
				$this->toJSON(array('result' => FALSE), true);
			}
		}
	}

	public function ajaxToggleSubscription() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('type', 'id'))) {
			$type = $_POST['type'];
			$ID = intval($_POST['id']);
			$ownerType = isset($_POST['ownerType']) ? $_POST['ownerType'] : '';
			$ownerID = isset($_POST['ownerID']) ? intval($_POST['ownerID']) : 0;
			$ownerID1 = isset($_POST['ownerID1']) ? intval($_POST['ownerID1']) : 0;

			$player = User::getUser();
			$result['result'] = false;
			if ($type == SUBSCRIPTION_GROUP) {
				$result['result'] = $player->toggleSubscribeToGroup($ID);
			} else if ($type == SUBSCRIPTION_COMPANY) {
				$result['result'] = $player->toggleSubscribeToCompany($ID);
			} else if ($type == SUBSCRIPTION_GAME) {
				$result['result'] = $player->toggleSubscribeToGame($ID);
			} else if ($type == SUBSCRIPTION_FORUM) {
				if ($ownerType == SUBSCRIPTION_COMPANY) {
					$result['result'] = $player->toggleSubscribeToCompanyForum($ownerID);
				} else if ($ownerType == SUBSCRIPTION_GAME) {
					$result['result'] = $player->toggleSubscribeToGameForum($ownerID);
				} else if ($ownerType == SUBSCRIPTION_GROUP) {
					$result['result'] = $player->toggleSubscribeToGroupForum($ownerID);
				}
			} else if ($type == SUBSCRIPTION_BOARD) {
				$result['result'] = $player->toggleSubscribeToBoard($ownerType, $ownerID, $ID);
			} else if ($type == SUBSCRIPTION_TOPIC) {
				$result['result'] = $player->toggleSubscribeToTopic($ownerType, $ownerID, $ownerID1, $ID);
			} else if ($type == SUBSCRIPTION_EVENT) {
				$result['result'] = $player->toggleSubscribeToEvent($ID);
			} else if ($type == SUBSCRIPTION_PLAYER) {
				$result['result'] = $player->toggleSubscribeToFriend($ID);
			} else if ($type == SUBSCRIPTION_NEWS) {
				$result['result'] = $player->toggleSubscribeToNewsItem($ID);
			} else if ($type == SUBSCRIPTION_FANCLUB) {
				$result['result'] = $player->toggleSubscribeToFanclub($ID);
			} else if ($type == SUBSCRIPTION_PLATFORM) {
				$result['result'] = $player->toggleSubscribeToPlatform($ID);
			}

			$this->toJSON($result, true);
			$player->purgeCache();
		}
	}

	/**
	 * Like action of post or reply
	 *
	 * @return JSON
	 */
	public function ajaxToggleLike() {
		if ($this->isAjax()) {
			$wall = new Wall();
			$totalLikes = $wall->toggleLike($_POST['type'], $_POST['pid'], $_POST['replyNumber'], $_POST['like']);

			$result['totalLikes'] = 0;
			$result['totalDislikes'] = 0;
			$result['result'] = false;
			if (count($totalLikes) == 2) {
				$result['totalLikes'] = $totalLikes[0];
				$result['totalDislikes'] = $totalLikes[1];
				$result['result'] = true;
			}

			$this->toJSON($result, true);
		}
	}

	public function ajaxShareOnWall() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('otype', 'oid')) and Auth::isUserLogged()) {
			$user = User::getUser();
			$str = '';

			switch ($_POST['otype']) {
				case SHARE_NEWS:
					if (MainHelper::validatePostFields(array('olang'))) {
						$val = array('user' => $user, 'oid' => $_POST['oid'], 'otype' => $_POST['otype'], 'olang' => $_POST['olang']);

						$post = $this->renderBlock('wall/share_' . SHARE_NEWS . '_preview', $val);
						$list = array(
							'user' => $user,
							'otype' => $_POST['otype'],
							'oid' => $_POST['oid'],
							'olang' => $_POST['olang'],
							'post' => $post
						);

						$str = $this->renderBlock('wall/ajaxShareOnWall', $list);
					}
					break;
			}

			echo $str;
		}
	}

	public function ajaxShowShareMessage() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('shareOwnerId', 'shareOwnerType', 'olang')) and Auth::isUserLogged()) {
			$user = User::getUser();

			$list = array(
				'otype' => $_POST['shareOwnerType'],
				'oid' => $_POST['shareOwnerId'],
				'olang' => $_POST['olang'],
			);

			echo $this->renderBlock('players/ajaxShareMessage', $list);
		}
	}

	public function ajaxShareMessage() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('post', 'otype', 'oid', 'olang')) and isset($_POST['recipients']) and Auth::isUserLogged()) {
			$user = User::getUser();

			$share = array('otype' => $_POST['otype'], 'oid' => $_POST['oid'], 'olang' => $_POST['olang']);

//			$user->sendMessage($_POST['recipients'], $_POST['post'], $share);
			$messClass = new Messages();
			$messClass->sendNewMessage($_POST['recipients'], $_POST['post'], $share);
		}
	}

	public function ajaxShareOnGroupWall() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('otype', 'oid')) and Auth::isUserLogged()) {
			$user = User::getUser();
			$str = '';

			switch ($_POST['otype']) {
				case SHARE_NEWS:
					if (MainHelper::validatePostFields(array('olang'))) {
						$val = array('user' => $user, 'oid' => $_POST['oid'], 'otype' => $_POST['otype'], 'olang' => $_POST['olang']);

						$post = $this->renderBlock('wall/share_' . SHARE_NEWS . '_preview', $val);
						$list = array(
							'user' => $user,
							'otype' => $_POST['otype'],
							'oid' => $_POST['oid'],
							'olang' => $_POST['olang'],
							'post' => $post
						);
						$str = $this->renderBlock('wall/ajaxShareOnGroupWall', $list);
					}
					break;
			}
			echo $str;
		}
	}

	public function joinus() {
		$list = array();
		$data = array();
		$data['title'] = $this->__('Join Us');
		$data['body_class'] = 'index_joinus';
		$data['selected_menu'] = '';
		$data['left'] = PlayerHelper::playerLeftSide('');
        $data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('main/joinus', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function joinusSuccessful() {
		$list = array();
		$data = array();
		$data['title'] = $this->__('Join Us');
		$data['body_class'] = 'index_joinus';
		$data['selected_menu'] = '';
		$data['left'] = PlayerHelper::playerLeftSide('');
        $data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('main/joinusSuccessful', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function join() {
		$user = User::getUser();
		if($user and MainHelper::validatePostFields(array('name', 'age', 'email', 'links', 'description'))) {
			$mail = new EmailNotifications();
			$mail->recruitment($user, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('joinus-successful'));
		} else { DooUriRouter::redirect(MainHelper::site_url('joinus')); };
	}

	public function rightCol() {
		if($this->isAjax() and isset($_SERVER['HTTP_REFERER'])) { echo PlayerHelper::playerRightSide(); };
	}

    public function ajaxSetRole() {
        $user = new User();
        $user->UpdateUserRole(User::getUser()->ID_PLAYER,$_POST['id']);
    }
    
    public function ajaxAddMemberRole() {
        if($this->isAjax()) {
            $role = isset($_POST['role']) ? $_POST['role'] : false;
            $ownerType = isset($_POST['ownerType']) ? $_POST['ownerType'] : false;
            $ownerID = isset($_POST['owner_id']) ? $_POST['owner_id'] : false;
            $playerID = isset($_POST['player_id']) ? $_POST['player_id'] : false;
            $player = $playerID ? User::getById($playerID) : false;
            
            if($ownerID && $player && $role && $ownerType) {
                $players = new Players();
                $data = $players->getMemberRoleType($ownerType, $ownerID, $player);
                $isAdmin = $data['owner']->isAdmin();
                if($isAdmin) {
                    $result['result'] = $players->updateMemberRole($data['op_rel'], $role, $ownerType, $data['id'], 1);
                    $this->toJSON($result, true);
                };
            };
        };
    }
    
    public function ajaxRemoveMemberRole() {
        if($this->isAjax()) {
            $role = isset($_POST['role']) ? $_POST['role'] : false;
            $ownerType = isset($_POST['ownerType']) ? $_POST['ownerType'] : false;
            $ownerID = isset($_POST['owner_id']) ? $_POST['owner_id'] : false;
            $playerID = isset($_POST['player_id']) ? $_POST['player_id'] : false;
            $player = $playerID ? User::getById($playerID) : false;
            
            if($ownerID && $player && $role && $ownerType) {
                $players = new Players();
                $data = $players->getMemberRoleType($ownerType, $ownerID, $player);
                $isAdmin = $data['owner']->isAdmin();
                if($isAdmin) {
                    $result['result'] = $players->updateMemberRole($data['op_rel'], $role, $ownerType, $data['id'], 0);
                    $this->toJSON($result, true);
                };
            };
        };
    }
    
	/*
	  public function allurl(){
	  Doo::loadCore('app/DooSiteMagic');
	  DooSiteMagic::showAllUrl();
	  }

	  public function debug(){
	  Doo::loadCore('app/DooSiteMagic');
	  DooSiteMagic::showDebug($this->params['filename']);
	  }

	  public function gen_sitemap_controller(){
	  //This will replace the routes.conf.php file
	  Doo::loadCore('app/DooSiteMagic');
	  DooSiteMagic::buildSitemap(true);
	  DooSiteMagic::buildSite();
	  }

	  public function gen_sitemap(){
	  //This will write a new file,  routes2.conf.php file
	  Doo::loadCore('app/DooSiteMagic');
	  DooSiteMagic::buildSitemap();
	  }

	  public function gen_site(){
	  Doo::loadCore('app/DooSiteMagic');
	  DooSiteMagic::buildSite();
	  }

	  public function gen_model(){
	  Doo::loadCore('db/DooModelGen');
	  DooModelGen::genMySQL();
	  }
	 */

    public function liveSearch() {
        $phrase = filter_input(INPUT_GET, 'q');
        if(!empty($phrase)) {
            $search = new Search();
            $data = array();
            $result = $search->getTopSearch($phrase, Doo::conf()->globalSearchLimit, 1);
            if(!empty($result)) {
                foreach($result as $r) {
                    $fieldtype = $r->FieldType;
                    $data[] = array(
                        "id" => $r->ID_ITEM,
                        "name" => DooTextHelper::limitChar($r->Data, 20, '...', 'utf8'),
                        "type" => ucfirst($this->__($fieldtype)),
                        "url" => MainHelper::site_url($fieldtype . '/' . $r->URL),
                    );
                };
                $return = json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE, 8194);
                echo $return;
                return TRUE;
            };
        };
    }

    public function subPageSearch() {
        $phrase = filter_input(INPUT_GET, "q");
        if($this->isAjax() && !empty($phrase)) {
            $search = new Search();
            $data = array();
            $inputType = $this->params['type'];

            switch(strtolower($inputType)) {
                case 'news':
                    $type = SEARCH_NEWS;
                    break;
                case 'players':
                    $type = SEARCH_PLAYER;
                    break;
                case 'groups':
                    $type = SEARCH_GROUP;
                    break;
                case 'companies':
                    $type = SEARCH_COMPANY;
                    break;
                case 'games':
                    $type = SEARCH_GAME;
                    break;
                case 'events':
                    $type = SEARCH_EVENT;
                    break;
                default:
            };

            $result = $search->getSubPageSearch($phrase, $type, 10);

            if(!empty($result)) {
                foreach($result as $r) {
                    $fieldtype = $r->FieldType;
                    $data[] = array(
                        "id" => $r->ID_ITEM,
                        "name" => DooTextHelper::limitChar($r->Data, 20),
                        "type" => ucfirst($this->__($fieldtype)),
                        "url" => MainHelper::site_url($fieldtype . "/" . $r->URL),
                    );
                };
                $this->toJSON($data, TRUE);
            };
        } else { DooUriRouter::redirect(MainHelper::site_url()); };
    }
    
}
?>
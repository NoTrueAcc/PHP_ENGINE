    <?php

    require_once "config_class.php";
    require_once "article_class.php";
    require_once "section_class.php";
    require_once "user_class.php";
    require_once "menu_class.php";
    require_once "banner_class.php";
    require_once "message_class.php";
    require_once "mail_class.php";

    abstract class Modules
    {
        protected $config;
        protected $article;
        protected $section;
        protected $user;
        protected $menu;
        protected $banner;
        protected $message;
        protected $data;
        protected $userInfo;

        public function __construct($db)
        {
            session_start();

            $this->config = new Config($db);
            $this->article = new Article($db);
            $this->section = new Section($db);
            $this->user = new User($db);
            $this->menu = new Menu($db);
            $this->banner = new Banner($db);
            $this->message = new Message($db);
            $this->data = $this->secureData($_GET);
            $this->userInfo = $this->getUser();
        }

        private function getUser()
        {
            $login = isset($_SESSION['login']) ? $_SESSION['login'] : "";
            $password = isset($_SESSION['password']) ? $_SESSION['password'] : "";

            return ($this->user->checkUser($login, $password)) ? $this->user->getUserOnLogin($login) : false;
        }

        private function secureData($data)
        {
            foreach ($data as $key => $value)
            {
                if(is_array($value))
                {
                    $this->secureData($value);
                }
                else
                {
                    $data[$key] = htmlspecialchars($value);
                }

            }

            return $data;
        }

        protected function getMessage($message = "")
        {
            if($message == "") {
                $message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
                unset($_SESSION['message']);
            }

            $str['message'] = $this->message->getText($message);

            return $this->getReplaceTemplate($str, "message_string");
        }

        public function getContent()
        {
            $str['title'] = $this->getTitle();
            $str['meta_description'] = $this->getDescription();
            $str['meta_key'] = $this->getKeyWords();
            $str['menu'] = $this->getMenu();
            $str['auth_user'] = $this->getAuthUser();
            $str['banners'] = $this->getBanners();
            $str['top'] = $this->getTop();
            $str['middle'] = $this->getMiddle();
            $str['bottom'] = $this->getBottom();

            return $this->getReplaceTemplate($str, 'main');
        }

        abstract protected function getTitle();
        abstract protected function getDescription();
        abstract protected function getKeyWords();
        abstract protected function getMiddle();

        protected function getMenu()
        {
            $menu = $this->menu->getAll();
            $text = "";

            for($i = 0; $i < count($menu); $i++)
            {
                $str['title'] = $menu[$i]['title'];
                $str['link'] = $menu[$i]['link'];

                $text .= $this->getReplaceTemplate($str, "menu_icon");
            }

            return $text;
        }

        protected function getCheckMailResult()
        {
            $data = isset($this->data['checkdata']) ? $this->user->validMailHash($this->data['checkdata']) : false;

            return  $data;

        }

        protected function getAuthUser()
        {
            if(!empty($this->userInfo))
            {
                $str['username'] = $this->userInfo['login'];

                return $this->getReplaceTemplate($str, "user_panel");
            }

            if(isset($_SESSION['error_auth']) && $_SESSION['error_auth'] == 1)
            {
                $str["message_auth"] = $this->getMessage("ERROR_AUTH");
                unset($_SESSION['error_auth']);
            }
            else
            {
                $str["message_auth"] = "";
            }

            return $this->getReplaceTemplate($str, 'form_auth');
    }

        protected function getBanners()
        {
            $banners = $this->banner->getAll();
            $text = "";

            for($i = 0; $i < count($banners); $i++)
            {
                $str['code'] = $banners[$i]['code'];

                $text .= $this->getReplaceTemplate($str, 'banner');
            }

            return $text;
        }

        protected function getBlogArticles($articles, $page)
        {
            $start = ($page - 1) * $this->config->countBlog;
            $end = (count($articles) > ($start + $this->config->countBlog)) ? ($start + $this->config->countBlog) : count($articles);
            $text = "";

            for($i = $start; $i < $end; $i++)
            {
                $str['title'] = $articles[$i]['title'];
                $str['intro_text'] = $articles[$i]['intro_text'];
                $str['date'] = $this->formatDate($articles[$i]['date']);
                $str['link_article'] = $this->config->address . "?view=article&amp;id=" . $articles[$i]['id'];
                $str['image_article'] = $this->config->dirImages . $articles[$i]['img_src'];
                $text .= $this->getReplaceTemplate($str, 'article_intro');
            }

            return $text;
        }

        protected function getPagination($count, $countOnPage, $link)
        {
            $countPages = ceil($count / $countOnPage);
            $str['number'] = 1;
            $str['link'] = $link;
            $pages = $this->getReplaceTemplate($str, 'number_page');
            $sym = (strpos($link, "?") !== false) ? "&amp;" : "?";

            for($i = 2; $i <= $countPages; $i++)
            {
                $str['number'] = $i;
                $str['link'] = $link . $sym . "page=$i";
                $pages .= $this->getReplaceTemplate($str, 'number_page');
            }

            $els['number_pages'] = $pages;

            return $this->getReplaceTemplate($els, 'pagination');
        }

        protected function formatDate($time)
        {
            return date("H-m-d H:i:s", $time);
        }

        protected function getTop()
        {
            return "";
        }

        protected function getBottom()
        {
            return "";
        }

        protected function getTemplate($name)
        {
            $text = file_get_contents($this->config->dirTmpl . $name . ".tpl");
            return str_replace("%address%", $this->config->address, $text);
        }

        protected function getReplaceTemplate($str, $template)
        {
            return $this->getReplaceContent($str, $this->getTemplate($template));
        }

        private function getReplaceContent($str, $content)
        {
            $search = array();
            $replace = array();
            $i = 0;

            foreach ($str as $key => $value)
            {
                $search[$i] = "%$key%";
                $replace[$i] = $value;
                $i++;
            }

            return str_replace($search, $replace, $content);
        }
    }

?>
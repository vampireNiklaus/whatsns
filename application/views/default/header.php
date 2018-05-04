<!--{template meta}-->
<body class="wshui">
<!--顶部logo和登录信息-->
<div class="whatsns_top">
<div class="container searchbox ">
<img src="{$setting['site_logo']}" class="logo">
<div class="searchtext search clearfix">
           <form target="_blank" name="searchform" action="{url question/search}" method="post" accept-charset="UTF-8">
                        <input name="utf8" type="hidden" value="✓">
                            <input type="text" tabindex="1" name="word" id="search-kw" value="" placeholder="请输入关键词检索" class="search-input s_input">

                            <a class="search-btn" href="javascript:void(null)" target="_self">
                               <button type="submit" class="btnup pull-right">
                            <i class="fa fa-search"></i>
                             </button>
                            </a>




                        </form>
     </div>
<nav class="ws_text_login_reg serach-nav">
   <!--{if 0!=$user['uid']}-->
 <!-- 如果用户登录，显示下拉菜单 -->
        <div class="user">
            <div data-hover="dropdown">
                <a class="avatar" href="{url user/default}"><img src="{$user['avatar']}" alt="120" /></a>
                <i class="fa fa-jiantouxia"></i>
                 <span class="badge msg-count " style="left:0px;"></span>
            </div>
            <ul class="dropdown-menu">
                 <!--{if $user['groupid']<=3}-->


                                     <li>
                    <a href="{SITE_URL}index.php?admin_main">
                        <i class="fa fa-gear"></i><span>后台管理</span>
                    </a>          </li>


                                    <!--{/if}-->
                                            <li>

                    <a href="{url message/system}">
                        <i class="fa fa-envelope"></i><span>系统私信</span>
                        <span class="badge s-msg-count"></span>
                    </a>
                      </li>
                           <li>

                    <a href="{url message/personal}">
                        <i class="fa fa-envelope-o"></i><span>个人私信</span>
                            <span class="badge p-msg-count"></span>
                    </a>
                      </li>

                <li>
                    <a href="{url user/default}">
                        <i class="fa fa-user"></i><span>我的主页</span>
                    </a>          </li>

                <li>
                    <a href="{url topic/userxinzhi/$user['uid']}">
                        <i class="fa fa-rss-square"></i><span>我的文章</span>
                    </a>          </li>

                <li>
                    <a href="{url user/attention/question}">
                        <i class="fa fa-star"></i><span>我的收藏</span>
                    </a>          </li>
                <li>
                    <a href="{url user/ask/1}">
                        <i class="fa fa-question-circle-o"></i><span>我的问题</span>
                    </a>          </li>
                <li>
                    <a rel="nofollow" data-method="delete" href="{url user/logout}">
                        <i class="fa fa-power-off"></i><span>退出</span>
                    </a>          </li>
            </ul>
        </nav>




     </div>
     <!--{else}-->
 <span>
        <a href="{url user/login}"  class="linklogin">
            登录
        </a>
    <a href="{url user/register}" class="linkreg">
        注册
    </a>
    </span>
        <!--{/if}-->


</nav>
</div>
</div>
<!--导航-->
  <!--{eval $headernavlist = $this->fromcache("headernavlist");}-->
<div class="whatsns_navtop">
    <div class="container">
    <nav class="widget-tag-nav clearfix">
        <!--{loop $headernavlist $headernav}-->
                    <!--{if $headernav['type']==1 && $headernav['available']}-->

                     <a href="{$headernav['format_url']}" title="{$headernav['title']}"  class="tag-item <!--{if strstr($headernav['url'],$regular)}--> current<!--{/if}-->"><span>{$headernav['name']}</span></a>

                    <!--{/if}-->
                    <!--{/loop}-->
    </nav>
        </div>
</div>


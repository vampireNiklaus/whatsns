<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>

<div class="ws_header">
    <i onclick="window.history.go(-1)" class="fa fa-angle-left"></i>
    <div class="ws_h_title">找回密码</div>
    <span class="ws_ab_reg" onclick="window.location.href='{url user/register}'"><i class="fa fa-registered"></i>注册</span>
</div>
  <div class="au_login_panelform sign">
     <form id="new_session" class="am-form" name="getpassform"  action="{url user/getpass}" method="post">
        <input type="hidden"  id="forward" name="return_url" value="{$forward}">
            <!-- 正常登录登录名输入框 -->
            <div class="input-prepend restyle js-normal">
                <input placeholder="手机号或邮箱/用户名" type="text"  name="username" id="username" >
                <i class="fa fa-user"></i>
            </div>

        

             <div class="input-prepend ">
                <input placeholder="你的邮箱" type="text" value="" id="email" name="email" onblur="check_email();">
                <i class="fa fa-envelope"></i>
            </div>

                  
            <div class="input-prepend  no-radius js-normal ">
                    <img src="{url user/code}" onclick="javascript:updatecode();" id="verifycode">

                    <input autocomplete="off" type="text" class="form-control" id="code" name="code" onblur="check_code();" placeholder="验证码">
              <i class="fa fa fa-get-pocket"></i>
                  </div>
            <input type="submit" name="submit" value="提交" class="sign-in-button">
        </form>
         <!--{if $setting['sinalogin_open']||$wxbrower||$setting['qqlogin_open']}-->
        <!-- 更多登录方式 -->
        <div class="more-sign">

            <h6>第三方登录</h6>
            <ul>
                <!--{if $setting['sinalogin_open']}-->
                <li><a class="weibo" href="{SITE_URL}plugin/sinalogin/index.php"><i class="fa fa-weibo"></i></a></li>
                <!--{/if}-->
               <!--{if $wxbrower}-->
                <li><a class="weixin" href="{SITE_URL}?plugin_weixin/wxauth"><i class="fa fa-wechat"></i></a></li>
                <!--{/if}-->
                <!--{if $setting['qqlogin_open']}-->
                <li><a class="qq" href="{SITE_URL}plugin/qqlogin/index.php"><i class="fa fa-qq"></i></a></li>
                <!--{/if}-->



            </ul>

        </div>
         <!--{/if}-->
    </div>



<script>

      //验证码
        function updatecode() {
            var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
            $('#verifycode').attr("src", img);
        }
        </script>


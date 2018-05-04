<!--{template meta}-->
<section class="ui-container">
    <style>
        body{
            background: #f1f5f8;
        }
    </style>
    <div class="ws_header">
        <i class="fa fa-home" onclick="window.location.href='{url index}'"></i>
        <div class="ws_h_title">{$setting['site_name']}</div>
        <i class="fa fa-search"  onclick="window.location.href='{url question/searchkey}'"></i>
    </div>
     <!--话题介绍-->
                    <div class="au_category_huati_info">
                           <div class="ui-row-flex">
                               <div class="ui-col">
                                   <div class="au_category_huati_img">
                                    <a href="{url category/view/$category['id']}">
                                       <img src="$category['bigimage']">
                                       </a>
                                   </div>
                               </div>
                               <div class="ui-col ui-col-3">
                                   <div class="au_category_huati_name"> <a  href="{url category/view/$category['id']}"> {$category['name']}</a></div>
                                   <div class="au_category_info_meta">
                                       <div class="au_category_info_meta_item"><i class="fa fa-question-circle hong"></i>{$category['questions']}个问题</div>
                                       <div class="au_category_info_meta_item"><i class="fa fa-user lan"></i>{$category['followers']}人关注</div>
                                       <div class="au_category_info_meta_item"><i class="fa fa-file-text-o ju "></i>{$trownum}篇文章</div>
                                   </div>
                               </div>
                         
                           </div>

                        <!--子话题-->
                        <div class="ui-row-flex">
                            <div class="ui-col ui-col au_category_info_childlist">

                                <div class="swiper-container" >
                                    <div class="swiper-wrapper">
                                      <!--{loop $sublist $index $cat}-->
                                        <div class="swiper-slide" data-swiper-autoplay="2000">
                                         
                                               
                                                    <div class="au_category_info_child">
                                                        <a href="{url category/view/$cat['id']}">
                                                        <div class="au_category_info_child_img">
                                                            <img src="$cat['image']">
                                                        </div>
                                                        <p class="au_category_info_child_text">{$cat['name']}</p>
                                                        </a>
                                                    </div>
                                               

                                            
                                        </div>
                                  <!--{/loop}--> 
                                    </div>

                                </div>
                                <!-- 如果需要导航按钮 -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>



                            </div>

                        </div>

                    </div>
                              <!--导航提示-->
                    <div class="ws_cat_au_brif">
                     <span class="ws_cat_au_bref_item  <!--{if all==$status}-->current<!--{/if}-->"><a href="{url category/view/$cid/all}">全部问题</a> </span>
                       
                        <span class="ws_cat_au_bref_item <!--{if 1==$status}-->current<!--{/if}-->"><a href="{url category/view/$cid/1}">
      未解决</a></span>
                        <span class="ws_cat_au_bref_item <!--{if 2==$status}-->current<!--{/if}-->"><a  href="{url category/view/$cid/2}"> 已解决</a></span>
                        <span class="ws_cat_au_bref_item <!--{if 6==$status}-->current<!--{/if}-->"> <a href="{url category/view/$cid/6}"> 推荐问题</a></span>
                       {if $category['isusearticle']}  <span class="ws_cat_au_bref_item"><a href="{url topic/catlist/$cid}"> 相关文章</a></span> {/if}
                    </div>
                     <!--列表部分-->
                    <div class="au_resultitems ws_cat_qlist">
                        <!--{loop $questionlist $index $question}-->
              <div class="au_item">
                          <div class="au_question_title"><a href="{url question/view/$question['id']}">{$question['title']}</a><span class="au_cat"><a href="{url category/view/$question['cid']}">{$question['category_name']}</a></span></div>
                          <div class="au_question_user_info">
                              {if $question['hidden']==1}
        <a class="avatar" >
             <img  class="au_question_user_info_avatar" src="{SITE_URL}static/css/default/avatar.gif"/>
        </a>
        <span>匿名用户</span>
        {else}
        
           <img onmouseover="pop_user_on(this, '{$question['authorid']}', 'text');"  onmouseout="pop_user_out();"  class="au_question_user_info_avatar" src="{$question['avatar']}"/><span><a class="fn" href="{url user/space/$question['authorid']}" >
           {$question['author']}
            {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
           </a></span>
                             
  
         
        {/if}
                           
                          
                              <span><i class="fa fa-twitch"></i>{$question['answers']}回答 </span>
           
                               {if $question['shangjin']!=0}
                              <span class="icon_rmb" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="如果回答被采纳将获得 {$question['shangjin']}元，可提现" ><img src="{SITE_URL}static/css/aozhou/dist/images/rmb.png" />悬赏$question['shangjin']元</span>
                               {/if}
                                 {if $question['askuid']>0}
                               <span class="au_q_yaoqing" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="邀请{$question['askuser']['username']}回答" ><i class="fa fa-twitch"></i>邀请回答</span>
                                 {/if}
                                  {if $question['hasvoice']!=0}
                                    <span class="au_q_yuyin"><i class="fa fa-microphone"></i>语音回答</span>
                                     {/if}
                          </div>
                           <div class="au_question_info_content">
                              
                                  {if $question['articleclassid']!=null&&$question['price']!=0}
                         <div class="box_toukan ">
											
										
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;阅读需支付&nbsp;$question['price']&nbsp;&nbsp;积分……</a>
											
											
										    
										</div>
                   {else}
                    {eval echo clearhtml($question['description']);}
                    {/if}
                           </div>
                           
                        </div>
                          <!--{/loop}-->
                    </div>
               <div class="pages">{$departstr}</div>
                    

<script>
    var swiper = new Swiper('.swiper-container', {
        loop:true,
        autoplay:2000,
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 10,
        // 如果需要前进后退按钮
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    });
    var intswper=setInterval("swiper.slideNext()", 2000);
    $(".swiper-container").hover(function(){
        clearInterval(intswper);
    },function(){
        intswper=setInterval("swiper.slideNext()", 2000);
    })
</script>
</section>
<!--{template footer}-->
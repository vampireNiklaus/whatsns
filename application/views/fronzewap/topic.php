<!--{template header}-->
<style>
    body{
        background: #f1f5f8;;
    }
</style>
        <!--{eval $categorylist=$this->fromcache('categorylist');}-->
                  <!--{if $categorylist }-->
   <!--热门主题-->
                    <div class="au_side_box" style="margin-top: .16rem">

                        <div class="au_box_title">

                            <div>
                                <i class="fa fa-windows huang"></i>热门话题
                               
                            </div>

                        </div>
                        <div class="au_side_box_content">
                            <ul>
                               <!--{loop $categorylist  $category1}-->
                                <li {if $category1['miaosu']} data-toggle="tooltip" data-placement="bottom" title="" data-original-title=" {eval echo clearhtml($category1['miaosu']);}" {/if}>
                                    <div class="_smallimage">
                                      <a href="{url topic/catlist/$category1['id']}">  <img src="{$category1['bigimage']}"></a>
                                    </div>
                                    <div class="_content">
                                      <div class="_rihgtc">
                                          <span class="subname">
                                           <a href="{url topic/catlist/$category1['id']}">{$category1['name']}</a>  
                                          </span>
                                          <span class="_yuedu">{$category1['followers']}人关注</span>
                                          <p class="_desc" >
                                                 {eval echo clearhtml($category1['miaosu']);}
                                         
                                           </p>
                                      </div>

                                    </div>
                                </li>
                                  <!--{/loop}--> 
                            </ul>
                        </div>
                    </div>
                        <!--{/if}-->
                        <!--最新文章-->
    <div class="au_side_box">

        <div class="au_box_title ">

            <div>
                <i class="fa fa-file-text-o lv"></i>最新文章

            </div>

        </div>
        <div class="au_side_box_content">
            <!--列表部分-->
                    <div class="au_resultitems">
                        <!--{loop $topiclist $index $topic}-->   
                        <div class="au_item"  {if $topic['image']!=null} style="height:2.2rem" {/if}>
                          <div class="au_question_title">    <a   href="{url topic/getone/$topic['id']}"  >{$topic['title']}</a></div>
                          <div class="au_question_user_info">
                               <a class="" href="{url user/space/$topic['authorid']}">
                    <img class="au_question_user_info_avatar" src="{$topic['avatar']}" >
                </a>  <span>      <a class="blue-link" target="_blank" href="{url user/space/$topic['authorid']}">
                {$topic['author']}
               {if $topic['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topic['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a></span><span><i class="fa fa-clock-o"></i>{$topic['format_time']} </span>
                            
                              <span><i class="fa fa-twitch"></i>{$topic['articles']} </span>
                            
                            
                          </div>
                           <div class="au_question_info_content">
                             
   {if $topic['image']!=null}  
   
          <div class="thumbnail_img">
                                   <a  href="{url topic/getone/$topic['id']}" >
            <img src="{$topic['image']}">
        </a>
                                  </div>
            {/if}
                                  {if $topic['price']!=0}
                         <div class="box_toukan ">
											
										
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;积分……</a>
											
											
										    
										</div>
                   {else}
                   {eval echo clearhtml($topic['description']);} 
                  
                    {/if}
                           </div>
                          
                        </div>
                   
    <!--{/loop}-->
                    </div>
            </div>
             <div class="pages" style="margin-bottom:15px;">{$departstr}</div>
        </div>
    <!--赏金猎人-->
<!--{template sider_duizhang}-->    

<!--{template footer}-->